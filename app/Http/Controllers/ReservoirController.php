<?php

namespace App\Http\Controllers;

use App\Models\Reservoir;
use App\Models\Member;
use Illuminate\Http\Request;
use Validator;
use PDF;

class ReservoirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservoirs = Reservoir::orderBy('title')->paginate(15)->withquerystring();
        $sort = 'title';
        $dir = 'asc';
        $defaultReservoir = 0;
        $members = Member::orderBy('surname')->get();
        $s = '';
        // Rusiavimas
        if($request->sort_by && $request -> dir){
            if($request -> sort_by == 'title' && $request -> dir == 'asc'){
                $reservoirs = Reservoir::orderBy('title')->paginate(15)->withquerystring();
            }
            elseif($request -> sort_by == 'title' && $request -> dir == 'desc'){
                $reservoirs = Reservoir::orderBy('title', 'desc')->paginate(15)->withquerystring();
                $dir = 'desc';
            }
            elseif($request -> sort_by == 'area' && $request -> dir == 'asc'){
                $reservoirs = Reservoir::orderBy('area')->paginate(15)->withquerystring();
                $sort = 'area';
            }
            elseif($request -> sort_by == 'area' && $request -> dir == 'desc'){
                $reservoirs = Reservoir::orderBy('area', 'desc')->paginate(15)->withquerystring();
                $sort = 'area';
                $dir = 'desc';
            } 
            else {
                $reservoirs = Reservoir::paginate(15)->withquerystring();
            }
        }    
        // Filtravimas
        elseif($request->reservoir_id){
            $reservoirs = Reservoir::where('reservoir_id', (int)$request->reservoir_id)->paginate(15)->withquerystring();
            $defaultReservoir = $request->reservoir_id;
        }
        // Paieska
        elseif($request->s){
            $reservoirs = Reservoir::where('name', 'like', '%'.$request->s.'%')->paginate(15)->withquerystring();
            $s = $request->s;
        }
        elseif($request->do_search){
            $reservoirs = Reservoir::where('name', 'like', '')->paginate(15)->withquerystring();
            $s = $request->s;
        }
        else {
            $reservoirs = Reservoir::paginate(15)->withquerystring();
        }

        return view('reservoir.index', [
            'reservoirs' => $reservoirs,
            'sort'=> $sort,
            'dir' => $dir,
            'members' => $members,
            'defaultReservoir' => $defaultReservoir,
            's' => $s
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservoir.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reservoir_title' => ['required', 'min:3', 'max:64'],
                'reservoir_area' => ['required', 'integer'],
                'reservoir_about' => ['required'],
            ]
            // ,
            // [
            //     'reservoir_name.min' => 'per mazai simboliu vardui',
            //     'reservoir_name.max' => 'nuimk kate ar veida nuo klavieturos',
            //     'reservoir_surname.min' => 'per mazai simboliu pavardei',
            //     'reservoir_surname.max' => 'nuimk kate ar veida nuo klavieturos'
            // ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $reservoir = new Reservoir;

        if ($request->has('reservoir_photo')) {
            $photo = $request->file('reservoir_photo');
            $imageName = 
            $request->reservoir_title. '-' .
            $request->reservoir_area. '-' .
            time(). '.' .
            $photo->getClientOriginalExtension();
            $path = public_path() . '/reservoirs-images/'; // serverio vidinis kelias
            $url = asset('reservoirs-images/'.$imageName); // url narsyklei (isorinis)
            $photo->move($path, $imageName); // is serverio tmp ===> i public folderi
            $reservoir->photo = $url;
        }
        
        $reservoir->title = $request->reservoir_title;
        $reservoir->area = $request->reservoir_area;
        $reservoir->about = $request->reservoir_about;
        $reservoir->save();
        return redirect()->route('reservoir.index')->with('success_message', 'New Horese added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function show(Reservoir $reservoir)
    {
        return view('reservoir.show', ['reservoir' => $reservoir]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservoir $reservoir)
    {
        return view('reservoir.edit', ['reservoir' => $reservoir]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservoir $reservoir)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reservoir_title' => ['required', 'min:3', 'max:64'],
                'reservoir_area' => ['required', 'integer'],
                'reservoir_about' => ['required'],
            ]
            // ,
            // [
            //     'reservoir_surname.min' => 'mano zinute'
            // ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        if ($request->has('delete_reservoir_photo')){
            if ($reservoir->photo) {
                $imageName = explode('/', $reservoir->photo);
                $imageName = array_pop($imageName);
                $path = public_path() . '/reservoirs-images/'.$imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
                $reservoir->photo = null;
            }

        }

        if ($request->has('reservoir_photo')) {

            if ($reservoir->photo) {
                $imageName = explode('/', $reservoir->photo);
                $imageName = array_pop($imageName);
                $path = public_path() . '/reservoirs-images/'.$imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $photo = $request->file('reservoir_photo');
            $imageName = 
            $request->reservoir_title. '-' .
            $request->reservoir_area. '-' .
            time(). '.' .
            $photo->getClientOriginalExtension();
            $path = public_path() . '/reservoirs-images/'; // serverio vidinis kelias
            $url = asset('reservoirs-images/'.$imageName); // url narsyklei (isorinis)
            $photo->move($path, $imageName); // is serverio tmp ===> i public folderi
            $reservoir->photo = $url;
        }

        $reservoir->title = $request->reservoir_title;
        $reservoir->area = $request->reservoir_area;
        $reservoir->about = $request->reservoir_about;
        $reservoir->save();
        return redirect()->route('reservoir.index')->with('success_message', 'Reservoir info updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservoir $reservoir)
    {
        if ($reservoir->photo) {
            $imageName = explode('/', $reservoir->photo);
            $imageName = array_pop($imageName);
            $path = public_path() . '/reservoirs-images/'.$imageName;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        if ($reservoir->reservoirHasMembers->count()) {
            return redirect()->route('reservoir.index')->with('info_message', 'Can not remove Reservoir, It still has Active Members');
        }
        $reservoir->delete();
        return redirect()->route('reservoir.index')->with('success_message', 'Reservoir has been removed');
    }

    public function pdf(Reservoir $reservoir)
    {
        $pdf = PDF::loadView('reservoir.pdf', ['reservoir' => $reservoir]);
        return $pdf->download($reservoir->title.'.pdf');
    }
}
