<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConcertController extends Controller
{
    public function index()
    {
        $concerts = Concert::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.concerts.index', compact('concerts'));
    }

    public function create()
    {
        return view('admin.concerts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'gate_open' => 'nullable',
            'label' => 'nullable|in:none,popular,trending,limited',
            'vip_price' => 'required|numeric|min:0',
            'festival_price' => 'required|numeric|min:0',
            'tribun_price' => 'required|numeric|min:0',
            'vip_seats' => 'required|integer|min:1',
            'festival_seats' => 'required|integer|min:1',
            'tribun_seats' => 'required|integer|min:1',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_url' => 'nullable|url',
            'description' => 'nullable|string',
            'lineup' => 'nullable|string',
        ]);

        try {
            $posterPath = $request->file('poster')->store('posters', 'public');
            
            $lineup = [];
            if ($request->lineup) {
                $lineup = explode("\n", $request->lineup);
                $lineup = array_map('trim', $lineup);
                $lineup = array_filter($lineup);
            }
            
            // Tentukan label (jika none, simpan null)
            $label = null;
            if ($request->label && $request->label !== 'none') {
                $label = $request->label;
            }
            
            $rowsPerCategory = [
                'VIP' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'],
                'Festival' => ['K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'],
                'Tribun' => ['U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD'],
            ];
            
            $vipCols = ceil($request->vip_seats / count($rowsPerCategory['VIP']));
            $festivalCols = ceil($request->festival_seats / count($rowsPerCategory['Festival']));
            $tribunCols = ceil($request->tribun_seats / count($rowsPerCategory['Tribun']));
            
            $categories = [
                [
                    'name' => 'VIP',
                    'price' => (int) $request->vip_price,
                    'total_seats' => (int) $request->vip_seats,
                    'available_seats' => (int) $request->vip_seats,
                    'description' => 'View terbaik, dekat panggung, merchandise eksklusif',
                    'color' => '#fbbf24',
                    'rows' => $rowsPerCategory['VIP'],
                    'cols' => $vipCols
                ],
                [
                    'name' => 'Festival',
                    'price' => (int) $request->festival_price,
                    'total_seats' => (int) $request->festival_seats,
                    'available_seats' => (int) $request->festival_seats,
                    'description' => 'Berdiri di area depan panggung',
                    'color' => '#60a5fa',
                    'rows' => $rowsPerCategory['Festival'],
                    'cols' => $festivalCols
                ],
                [
                    'name' => 'Tribun',
                    'price' => (int) $request->tribun_price,
                    'total_seats' => (int) $request->tribun_seats,
                    'available_seats' => (int) $request->tribun_seats,
                    'description' => 'Duduk nyaman dengan view panggung',
                    'color' => '#34d399',
                    'rows' => $rowsPerCategory['Tribun'],
                    'cols' => $tribunCols
                ]
            ];
            
            $concert = Concert::create([
                'name' => $request->name,
                'artist' => $request->artist,
                'venue' => $request->venue,
                'city' => $request->city,
                'date' => $request->date,
                'time' => $request->time,
                'gate_open' => $request->gate_open ?? $request->time,
                'description' => $request->description,
                'poster' => $posterPath,
                'youtube_url' => $request->youtube_url,
                'lineup' => $lineup,
                'label' => $label,
                'categories' => $categories,
                'available_seats' => $request->vip_seats + $request->festival_seats + $request->tribun_seats
            ]);
            
            $this->generateSeats($concert, $categories, $rowsPerCategory);
            
            return redirect()->route('admin.concerts.index')
                ->with('success', 'Konser "'. $request->name .'" berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    private function generateSeats($concert, $categories, $rowsPerCategory)
    {
        foreach ($categories as $category) {
            $rows = $rowsPerCategory[$category['name']] ?? ['A', 'B', 'C', 'D', 'E'];
            $cols = $category['cols'];
            $totalSeats = $category['total_seats'];
            $seatCount = 0;
            
            foreach ($rows as $row) {
                for ($col = 1; $col <= $cols; $col++) {
                    if ($seatCount >= $totalSeats) break;
                    
                    $seatCode = $row . $col;
                    
                    Seat::create([
                        'concert_id' => $concert->_id,
                        'seat_code' => $seatCode,
                        'category' => $category['name'],
                        'row_code' => $row,
                        'seat_number' => $col,
                        'status' => 'available',
                        'price' => $category['price']
                    ]);
                    
                    $seatCount++;
                }
                if ($seatCount >= $totalSeats) break;
            }
        }
    }

    public function edit($id)
    {
        $concert = Concert::findOrFail($id);
        return view('admin.concerts.edit', compact('concert'));
    }

    public function update(Request $request, $id)
    {
        $concert = Concert::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'label' => 'nullable|in:none,popular,trending,limited',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->except(['_token', '_method', 'poster']);
        
        // Proses label
        if (isset($data['label']) && $data['label'] === 'none') {
            $data['label'] = null;
        }
        
        if ($request->hasFile('poster')) {
            if ($concert->poster) {
                Storage::disk('public')->delete($concert->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }
        
        $concert->update($data);
        
        return redirect()->route('admin.concerts.index')
            ->with('success', 'Konser berhasil diupdate');
    }

    public function destroy($id)
    {
        $concert = Concert::findOrFail($id);
        
        if ($concert->poster) {
            Storage::disk('public')->delete($concert->poster);
        }
        
        Seat::where('concert_id', $concert->_id)->delete();
        
        $concert->delete();
        
        return redirect()->route('admin.concerts.index')
            ->with('success', 'Konser berhasil dihapus');
    }
    
    public function seats($id)
    {
        $concert = Concert::findOrFail($id);
        $seats = Seat::where('concert_id', $concert->_id)->get();
        
        $seatsByCategory = [];
        foreach ($seats as $seat) {
            $seatsByCategory[$seat->category][] = $seat;
        }
        
        return view('admin.concerts.seats', compact('concert', 'seatsByCategory'));
    }
    
    public function updateSeatStatus(Request $request, $id)
    {
        $request->validate([
            'seat_code' => 'required|string',
            'status' => 'required|in:available,booked,locked'
        ]);
        
        $seat = Seat::where('concert_id', $id)
            ->where('seat_code', $request->seat_code)
            ->firstOrFail();
        
        $seat->status = $request->status;
        $seat->save();
        
        return response()->json(['success' => true]);
    }
}