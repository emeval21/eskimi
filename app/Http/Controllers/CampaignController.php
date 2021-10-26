<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Campaign;
use App\Http\Resources\Campaign as CampaignResource;
Use Exception;


class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get campaigns
        $campaigns = Campaign::orderBy('id', 'desc')->paginate(10);

        //return campaigns are resource
        return CampaignResource::collection($campaigns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'daily_budget' => 'required',
            'total_budget' => 'required',
            'from' => 'required',
            'to' => 'required',
            'attachments' => 'required'
        ]);
        // Handle File Upload
        $fileNameToStore = 'default.jpg';
        if($request->hasFile('attachments')){
            $size = count($request->file('attachments'));
            $fileNameToStore = '';
            for($i =0;$i < $size; $i++){
                $image = $request->file('attachments')[$i];
                // Get filename with the extension
                $filenameWithExt = $image->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $image->getClientOriginalExtension();
                // Filename to store
                $randomNumber = random_int(100000, 999999);
                $fileNameToStoreFolder= $randomNumber.'_'.time().'.'.$extension;
                $fileNameToStore.= '||'.$randomNumber.'_'.time().'.'.$extension;
                // Upload Image
                $path = $image->storeAs('public/campaign_images', $fileNameToStoreFolder);
            }           
            // make thumbnails
            /* $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('attachments')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/campaign_images/'.$thumbStore); */
		
        }
        //
        $campaign = new Campaign;

        $campaign->id = $request->input('campaign_id');
        $campaign->name = $request->input('name');
        $campaign->daily_budget = $request->input('daily_budget');
        $campaign->total_budget = $request->input('total_budget');
        $campaign->from = $request->input('from');
        $campaign->to = $request->input('to');
        if($request->hasFile('attachments')){
            $campaign->campaign_image = $fileNameToStore;
        }
        // $request->input('campaign_image');

        if($campaign->save()){
            return new CampaignResource($campaign);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Campaign      

        $campaign = Campaign::find($id);
        
        if (!isset($campaign)){
            return response()->json( ['err' => 'No Campaign Found', 'statusText' => 'Stopped here'], 401 );
        }
        // return single campaign as a resource
        return new CampaignResource($campaign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campaign = Campaign::find($id);
        
        if (!isset($campaign)){
            return response()->json( ['err' => 'Campaign Doest Not Exist', 'statusText' => 'Stopped here'], 401 );
        }
        ///
        $oldDbImages = $campaign->campaign_image;   
        //return response()->json( ['err' => $count , 'statusText' => "After image processor"], 401 );
        $this->validate($request, [
            'name' => 'required',
            'daily_budget' => 'required',
            'total_budget' => 'required',
            'from' => 'required',
            'to' => 'required'            
        ]);
        // Handle File Upload
        $fileNameToStore = 'default.jpg';
        if($request->hasFile('attachments')){
            $size = count($request->file('attachments'));
            $fileNameToStore = '';
            for($i =0;$i < $size; $i++){
                $image = $request->file('attachments')[$i];
                // Get filename with the extension
                $filenameWithExt = $image->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $image->getClientOriginalExtension();
                // Filename to store
                $randomNumber = random_int(100000, 999999);
                $fileNameToStoreFolder= $randomNumber.'_'.time().'.'.$extension;
                $fileNameToStore.= '||'.$randomNumber.'_'.time().'.'.$extension;
                // Upload Image
                $path = $image->storeAs('public/campaign_images', $fileNameToStoreFolder);
            }           
            // make thumbnails
            /* $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('attachments')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/campaign_images/'.$thumbStore); */
		
        }
        
        
        $campaign->id = $request->input('campaign_id');
        $campaign->name = $request->input('name');
        $campaign->daily_budget = $request->input('daily_budget');
        $campaign->total_budget = $request->input('total_budget');
        $campaign->from = $request->input('from');
        $campaign->to = $request->input('to');
        if($request->hasFile('attachments')){
            $campaign->campaign_image = $fileNameToStore;
            /// here we split the images 
            $string = explode('||', $oldDbImages);
            foreach ($string as $img) {
                if($img != 'default.jpg'){
                    // Delete Image
                    Storage::delete('public/campaign_images/'.$img);
                }
            }            
        }
        // $request->input('campaign_image');

        if($campaign->save()){
            return new CampaignResource($campaign);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Get Campaign
        $campaign = Campaign::find($id);

        //Check if post exists before deleting
        if (!isset($campaign)){
            return response()->json( ['err' => 'No Campaign Found', 'statusText' => 'Stopped here'], 401 );
        }

        $oldDbImages = $campaign->campaign_image;  
        $string = explode('||', $oldDbImages);
        foreach ($string as $img) {
            if($img != 'default.jpg'){
                // Delete Image
                Storage::delete('public/campaign_images/'.$img);
            }
        }  
        /* if($campaign->campaign_image != 'default.jpg'){
            // Delete Image
            Storage::delete('public/campaign_images/'.$campaign->campaign_image);
        } */

        // return single campaign as a resource
        if($campaign->delete()){
            return new CampaignResource($campaign);
        }
        
    }
}
