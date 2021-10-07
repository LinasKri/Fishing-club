<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Reservoir;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = Member::orderBy('surname')->paginate(15)->withquerystring();
        $sort = 'surname';
        $dir = 'asc';
        $defaultReservoir = 0;
        $reservoirs = Reservoir::orderBy('title')->get();
        $s = '';
        // Rusiavimas
        if($request->sort_by && $request -> dir){
            if($request -> sort_by == 'surname' && $request -> dir == 'asc'){
                $members = Member::orderBy('surname')->paginate(15)->withquerystring();
            }
            elseif($request -> sort_by == 'surname' && $request -> dir == 'desc'){
                $members = Member::orderBy('surname', 'desc')->paginate(15)->withquerystring();
                $dir = 'desc';
            }
            elseif($request -> sort_by == 'name' && $request -> dir == 'asc'){
                $members = Member::orderBy('name')->paginate(15)->withquerystring();
                $sort = 'name';
            }
            elseif($request -> sort_by == 'name' && $request -> dir == 'desc'){
                $members = Member::orderBy('name', 'desc')->paginate(15)->withquerystring();
                $sort = 'name';
                $dir = 'desc';
            } 
            else {
                $members = Member::paginate(15)->withquerystring();
            }
        }    
        // Filtravimas
        elseif($request->reservoir_id){
            $members = Member::where('reservoir_id', (int)$request->reservoir_id)->paginate(15)->withquerystring();
            $defaultReservoir = $request->reservoir_id;
            
        }
        // Paieska
        elseif($request->s){
            $members = Member::where('surname', 'like', '%'.$request->s.'%')->paginate(15)->withquerystring();
            $s = $request->s;
        }
        elseif($request->do_search){
            $members = Member::where('surname', 'like', '')->paginate(15)->withquerystring();
            $s = $request->s;
        }
        else {
            $members = Member::paginate(15)->withquerystring();
        }

        return view('member.index', [
            'members' => $members,
            'sort'=> $sort,
            'dir' => $dir,
            'reservoirs' => $reservoirs,
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
        $reservoirs = Reservoir::orderBy('title')->get();
        return view('member.create', ['reservoirs' => $reservoirs]);
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
                'member_name' => ['required', 'min:2', 'max:255', 'regex:/^[a-ząčęėįšųžĄČĘĖĮŠŲŽ]+$/i'],
                'member_surname' => ['required', 'min:3', 'max:20','regex:/^[a-ząčęėįšųžĄČĘĖĮŠŲŽ]+$/i' ],
                'member_live' => ['required','min:1', 'max:10'],
                'member_experience' => ['required','min:1', 'max:10'],
                'member_registered' => ['required','min:1', 'max:10'],
                'reservoir_id' => ['required', 'integer', 'min:1']
            ]
            // ,
            // [
            //     'master_surname.min' => 'mano zinute'
            // ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $member = new Member;
        $member->name = $request->member_name;
        $member->surname = $request->member_surname;
        $member->live = $request->member_live;
        $member->experience = $request->member_experience;
        $member->registered = $request->member_registered;
        $member->reservoir_id = $request->reservoir_id;
        $member->save();
        return redirect()->route('member.index')->with('success_message', 'New Member added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $reservoirs = Reservoir::orderBy('title')->get();
        return view('member.edit', ['member' => $member, 'reservoirs' => $reservoirs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'member_name' => ['required', 'string', 'min:2', 'max:255'],
                'member_surname' => ['required', 'string', 'min:3', 'max:20'],
                'member_live' => ['required', 'string', 'min:1', 'max:50'],
                'member_experience' => ['required','min:1', 'max:10'],
                'member_registered' => ['required','min:1', 'max:10'],
                'reservoir_id' => ['required', 'integer', 'min:1']
            ]
            // [
            //     'master_surname.min' => 'mano zinute'
            // ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $member->name = $request->member_name;
        $member->surname = $request->member_surname;
        $member->live = $request->member_live;
        $member->experience = $request->member_experience;
        $member->registered = $request->member_registered;
        $member->reservoir_id = $request->reservoir_id;
        $member->save();
        return redirect()->route('member.index')->with('success_message', 'Member updated👆');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success_message', 'Succsessfuly deleted Member ☠');
    }
}
