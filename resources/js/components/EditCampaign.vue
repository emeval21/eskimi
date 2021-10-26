<template>
    <div>
        <h3>
            Edit Campaign
        </h3>
        <form @submit.prevent="handleSubmit($event)" class="mb-3" ref="myForm" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="campaign.name">
                            Campaign Name 
                        </label>
                        <input type="text" class="form-control" name="name" placeholder="Campaign Name" required="required" v-model="campaign.name" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_image">Campaign Image
                            <small><em class="text-info">Leave this field if you are not changing the images</em></small>
                        </label>
                        <!-- <input type="file" ref="file" class="form-control"  placeholder="Campaign Image" name="campaign_image" 
                        id="campaign_image" v-on:change="onFileChange" > -->
                        <input type="file" multiple="multiple" id="attachments" class="form-control" name="campaign_image" @change="uploadFieldChange">
                        <div class="attachment-holder animated fadeIn" v-cloak v-for="attachment in attachments" v-bind:key="attachment.size" style="float: left;padding: 2px 4px;"> 
                            <small class=" text-primary ">{{ attachment.name + ' (' + Number((attachment.size / 1024 / 1024).toFixed(1)) + 'MB)'}}</small> 
                            <small class="" style="background: red; cursor: pointer;" @click="removeAttachment(attachment)">
                                <button class="btn btn-sm btn-danger" style="padding: 2px 4px;font-size: 12px;">X</button>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="campaign.daily_budget">Daily Budget</label>
                        <input type="number" class="form-control" name="daily_budget" placeholder="Daily Budget" required="required" v-model="campaign.daily_budget">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="campaign.total_budget">Total Budget</label>
                        <input type="text" class="form-control" name="total_budget" placeholder="Total Budget" required="required" v-model="campaign.total_budget">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="campaign.from">Start From</label>
                        <input type="date" class="form-control" placeholder="Start From" name="from" required="required" v-model="campaign.from">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="campaign.to">Ends</label>
                        <input type="date" class="form-control" placeholder="Ends" name="to" required="required" v-model="campaign.to">
                        <input type="hidden"  name="campaign_id" required="required" v-model="campaign.campaign_id">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <div class="card card-body mb-2" v-for="error in errors" v-bind:key="error.id">
            
            <div class="row" v-if="error!=''" >
                <div class="col-md-12 text-danger">
                    <small> {{ error.name }} </small>
                    <small> {{ error.daily_budget }} </small>
                    <small> {{ error.total_budget }} </small>
                    <small> {{ error.from }} </small>
                    <small> {{ error.to }} </small>
                </div>
            </div>    
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            errors:[],
            campaign:{
                id: '',
                name: '',
                daily_budget: '',
                total_budget: '',
                from: '',
                to: '',
                campaign_image: '',
                campaign_id: '',
            }, 
            attachments: [],
            file: '',
            myFormData: new FormData() ,
            edit: false            
        }
        
    },

    created(){
        let uri = window.location.search.substring(1); 
        let params = new URLSearchParams(uri);
        var id = params.get("id");
        this.fetchCampaign(id);
        
    },

    methods: {
        onFileChange(e) {
            var input = document.getElementById('campaign_image');
            var file = input.files[0];
            this.campaign.campaign_image = file;
            console.log(this.campaign.campaign_image);
        },
        getAttachmentSize() {                
            this.upload_size = 0; // Reset to beginningƒ
            this.attachments.map((item) => { this.upload_size += parseInt(item.size); });
            
            this.upload_size = Number((this.upload_size).toFixed(1));
            this.$forceUpdate();
        },
        prepareFields() {            
            if (this.attachments.length > 0) {
                for (var i = 0; i < this.attachments.length; i++) {
                    let attachment = this.attachments[i];
                    this.myFormData.append('attachments[]', attachment);
                }
            }
        },
        removeAttachment(attachment) {
            
            this.attachments.splice(this.attachments.indexOf(attachment), 1);
            
            this.getAttachmentSize();
        },
        // This function will be called every time you add a file
        uploadFieldChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            for (var i = files.length - 1; i >= 0; i--) {
                this.attachments.push(files[i]);
            }
            // Reset the form to avoid copying these files multiple times into this.attachments
            document.getElementById("attachments").value = [];
        },
        get_url(){

            var currentUrl = window.location.pathname;

            console.log(currentUrl);

        },
        fetchCampaign(id){
            let vm = this;
            var page_url = `api/campaign/${id}`;
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                if(res.err){
                    console.log(res);
                    alert(res.err);
                    window.location.href = "./"
                }else{
                    this.campaign = res.data;
                    this.campaign.campaign_id = this.campaign.id;
                }     
                //console.log(this.campaign_id);
            })
            .catch(err => console.log(err));
        },
        handleSubmit(e) {
            var id = this.campaign.campaign_id;
            //var myFormData = new FormData(this.$refs.myForm);
            this.prepareFields();
            this.myFormData.append('campaign_id', this.campaign.campaign_id);
            this.myFormData.append('name', this.campaign.name);
            this.myFormData.append('daily_budget', this.campaign.daily_budget);
            this.myFormData.append('total_budget', this.campaign.total_budget);
            this.myFormData.append('from', this.campaign.from);
            this.myFormData.append('to', this.campaign.to);            
            //console.log(myFormData);
            axios({
                    method: 'post',
                    url: `api/campaign/${id}`,
                    data: this.myFormData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })          
            .then(res => res)
            .then(data => {
                if(data.err){
                    console.log(data);
                    alert(data.err);
                }else{
                    console.log(data);
                    alert('Campaign Edited');
                    var check = confirm('Do you want to continue to Home page?');
                    if(check){
                        window.location='./';
                    }
                    
                }  
                
            }).catch(
                //err => {console.log(err.response.data), this.errors = err.response.data}
                err => {console.log(err)}
            );   
            this.resetData();          
        },
        resetData() {
            this.myFormData = new FormData(); // Reset it completely
            this.attachments = [];
        },
    }
}
</script>
