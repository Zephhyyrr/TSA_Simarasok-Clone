<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Booking;
use App\Models\Homestay;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $query = $request->input('q');

        // if (!empty($query)) {
        //     $booking = Booking::where('name', 'like', '%' . $query . '%')->latest()->paginate(10);
        // } else {
        //     $booking = Booking::latest()->paginate(10);
        // }

        // return view("admin.booking.index", ['booking' => $booking, 'q' => $query]);

        $booking = Booking::latest()->Cari()->paginate(10);

        return view("admin.booking.index", ['booking' => $booking, 'q' => request('q')]);

    }

    // index yang udah baim(in case gak tau kalau aku yang ubah) gubah
    // >>> Bagas: jir, pake watermark -v-)
    // BTW query ubah jadi q lagi
    /*
        public function index()
        {
            $query = request('q');

            $booking = Booking::latest()->cari($query)->paginate(10);

            return view("admin.booking.index", ['booking' => $booking, 'q' => $query]);
        }
    */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countryCodes = $this->getCountryCodes();
        return view('admin.booking.create', ['homestay'=>Homestay::all(), 'countryCodes'=>$countryCodes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'notelp' => 'required',
            'homestay_id' => 'required|exists:homestays,id',
        ]);
        
        $notelp = $request->input('country_code') . $request->input('notelp');

        Booking::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'notelp' => $notelp,
            'checkin' => $request->input('checkin'),
            'checkout' => $request->input('checkout'),
            'homestay_id' => $request->input('homestay_id'),
        ]);
        return redirect('/admin/booking')->with('success', 'Berhasil menambahkan bookingan baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $booking = Booking::findOrFail($id);
    $homestay = Homestay::all();
    $countryCodes = $this->getCountryCodes();

    $notelp = $booking->notelp;
    $countryCode = '+62'; // default ke Indonesia jika tidak ditemukan
    
    // Loop melalui kode negara yang dikenal untuk memisahkan kode negara dan nomor telepon
    foreach ($countryCodes as $code => $country) {
        if (strpos($notelp, $code) === 0) {
            $countryCode = $code;
            $notelp = substr($notelp, strlen($countryCode));
            break;
        }
    }

    return view('admin.booking.edit', compact('booking', 'countryCodes', 'countryCode', 'notelp', 'homestay'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'notelp' => 'required',
            'homestay_id' => 'required|exists:homestays,id',
        ]);
        $notelp = $request->input('country_code') . $request->input('notelp');
        $booking = Booking::findOrFail($id);
        $booking->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'notelp' => $notelp,
            'checkin' => $request->input('checkin'),
            'checkout' => $request->input('checkout'),
            'homestay_id' => $request->input('homestay_id'),
        ]);
        return redirect('/admin/booking')->with('warining', 'Berhasil mengubah bookingan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Booking::findOrFail($id)->delete();
        return redirect('/admin/booking')->with('danger', 'Berhasil menghapus bookingan.');
    }

    // Booking sebagai tamu
    public function formBooking(Request $request)
    {
        $countryCodes = $this->getCountryCodes();
        return view('frontend.homestay.booking', ['homestay'=>Homestay::findOrFail($request->homestay_id), 'countryCodes'=>$countryCodes]);
    }

    // Booking sebagai tamu
    public function booking(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'notelp' => 'required',
            'homestay_id' => 'required|exists:homestays,id',
        ]);
    
        $notelp = $request->input('country_code') . $request->input('notelp');
    
        Booking::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'notelp' => $notelp,
            'checkin' => $request->input('checkin'),
            'checkout' => $request->input('checkout'),
            'homestay_id' => $request->input('homestay_id'),
        ]);
    
        $cp = Homestay::findOrFail($request->input('homestay_id'))->notelp;
        $cp = str_replace('+', '', $cp);

        $waktu = date('H') >= 5 && date('H') < 12 ? 'pagi' : (date('H') >= 12 && date('H') < 18 ? 'siang' : 'malam');
        $pemesan = $request->input('name');
        $homestay_name = Homestay::findOrFail($request->input('homestay_id'))->name;
        $checkin = date('d F', strtotime($request->input('checkin')));
        $checkout = date('d F', strtotime($request->input('checkout')));

        $msg = "Selamat $waktu, \nSaya $pemesan, ingin memesan kamar di $homestay_name dari tanggal $checkin sampai $checkout.";
        $msg = rawurlencode($msg);
        $whatsappUrl = "https://api.whatsapp.com/send?phone=$cp&text=$msg";
        // dd($whatsappUrl);

        $media = Homestay::findOrFail($request->input('homestay_id'))->media->first()->nama;
        $nama = Homestay::findOrFail($request->input('homestay_id'))->name;
    
        return view('frontend.homestay.sendWA', [
            'whatsappUrl' => $whatsappUrl, 
            'media' => $media,
            'nama' => $nama,
        ]);
    }    

    // approve bookingan
    public function approve(string $id){
        $bookingan=Booking::findOrFail($id);
        if($bookingan->status=='approved'){
            $bookingan->update(['status'=>'canceled']);
            $message = 'Bookingan '.$bookingan->nama.' dibatalkan';
        }else{
            $bookingan->update(['status'=>'approved']);
            $message = 'Bookingan '.$bookingan->nama.' disetujui';
        }
        return redirect('admin/booking')->with('success', $message);
    }

    private function getCountryCodes()
    {
        $client = new Client();
        $response = $client->get('https://restcountries.com/v3.1/all');
        $countries = json_decode($response->getBody(), true);

        $countryCodes = [];
        foreach ($countries as $country) {
            if (isset($country['idd']['root']) && isset($country['idd']['suffixes'])) {
                $code = $country['idd']['root'] . $country['idd']['suffixes'][0];
                $countryCodes[$code] = "($code) " . $country['name']['common'];
            }
        }

        // Sort the array by country name
        asort($countryCodes);

        return $countryCodes;
    }
}
