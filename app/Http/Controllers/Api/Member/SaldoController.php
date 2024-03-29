<?php

namespace App\Http\Controllers\Api\Member;

use App\Models\{Member, Payment};
use Illuminate\Support\Facades\{DB, Http};

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaldoController extends Controller
{
    public function __construct()
    {
        return $this->middleware('jwt.auth')->except('webhooks');
    }

    // Lihat Saldo
    public function index()
    {
        $data = Member::where('id', auth('member')->id())->first();

        return $this->sendResponse('success', 'Saldo berhasil dimuat', $data->saldo, 200);
    }

    // Lihat data transaksi
    public function transaksi()
    {
        $data = Payment::where('kode_member', auth('member')->user()->kode_member)->orderBy('id', 'DESC')->get();

        return $this->sendResponse('success', 'Riwayat transaksi berhasil dimuat', $data, 200);
    }

    // Isi saldo melalui kasir
    public function isiSaldo(Request $request)
    {
        $this->validate($request, [
            'kode_member' => 'required',
            'jumlah' => 'required'
        ]);

        DB::beginTransaction();
        $member = Member::where('kode_member', $request->kode_member)->firstOrFail();

        $member->update([
            'saldo' => $member->saldo + $request->jumlah
        ]);

        Payment::create([
            'order_id'     => 'KASIR-' . date('dmyHis') . '-' . $member->id,
            'jumlah'       => $request->jumlah,
            'kode_member'  => $request->kode_member,
            'nama_member'  => $member->nama,
            'nomor_member' => $member->nomor,
            'bank'         => 'Kasir',
            'status'       => 1
        ]);
        DB::commit();

        return $this->sendResponse('success', 'Transaksi berhasil, saldo ditambahkan', $request->jumlah, 200);
    }

    // Isi saldo dengan topup
    public function store(Request $request)
    {
        $order_id = Str::upper($request->bank) . "-" . date('dmyHis') . '-' . auth('member')->id();

        DB::beginTransaction();
        $data = $this->proses($request, $order_id);

        Payment::create([
            'order_id'     => $order_id,
            'jumlah'       => $request->jumlah,
            "kode_member"  => auth('member')->user()->kode_member,
            "nama_member"  => auth('member')->user()->nama,
            "nomor_member" => auth('member')->user()->nomor,
            'bank'         => $request->bank
        ]);
        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dilakukan',
            'data'  => [
                'order_id' => $data['order_id'],
                'transaction_status' => $data['transaction_status'],
                'jumlah' => $data['gross_amount'],
                'bank' => Str::upper($data['va_numbers'][0]['bank']),
                'va_numbers' => $data['va_numbers'][0]['va_number'],
                'transaction_date' => $data['transaction_time']
            ]
        ]);
    }

    // Proses transaksi
    public function proses($request, $order_id)
    {
        $res = Http::withBasicAuth(env('SERVER_KEY_MIDTRANS'), '')
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->post('https://api.sandbox.midtrans.com/v2/charge', [
                "payment_type" => "bank_transfer",

                "transaction_details" => [
                    "gross_amount" => $request->input('jumlah'),
                    "order_id" => $order_id
                ],

                "customer_details" => [
                    "email" => auth('member')->user()->kode_member,
                    "first_name" => auth('member')->user()->nama,
                    "phone" => auth('member')->user()->nomor
                ],

                "bank_transfer" => [
                    "bank" => $request->input('bank'),
                ]
            ]);

        $data = $res->json();

        if ($data['status_code'] == '500') {
            return $this->sendResponse('failed', 'Fitur sedang dalam perbaikan', null, 400);
        }

        return $data;
    }

    // Webhook Transaksi
    public function webhooks(Request $request)
    {
        $notification_body = json_decode($request->getContent(), true);

        $order_id = $notification_body['order_id'];

        $transaction_status = $notification_body['transaction_status'];

        $status = $notification_body['status_code'];

        $jumlah = explode('.', $notification_body['gross_amount'])[0];

        if ($transaction_status == 'settlement' and $status == '200') {

            $payment = Payment::where('order_id', $order_id)->first();

            $payment->update([
                'status' => 1
            ]);

            $id_member = explode('-', $order_id);

            $member = Member::where('id', $id_member[2])->first();

            $member->update([
                'saldo' => $member->saldo + $jumlah
            ]);
        } else if ($transaction_status == 'expire' || $transaction_status == 'cancel') {
            $payment = Payment::where('order_id', $order_id)->first();

            $payment->update([
                'status' => 2
            ]);
        }

        return;
    }
}
