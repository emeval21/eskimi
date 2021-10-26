<template>
    <div>
        <h3>
            Add Campaign
        </h3>
        <form v-on:submit.prevent="handleSubmit($event)" class="mb-3" ref="myForm" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Campaign Name</label>
                        <input type="text"  class="form-control" required="required"  placeholder="Campaign Name" 
                        v-model="campaign.name" name="name" id="name" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_image">Campaign Image</label>
                        <!-- <input type="file" multiple="multiple" name="campaign_image" id="campaign_image"  class="form-control" 
                        required="required"  v-on:change="onFileChange" /> -->
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
                        <label for="daily_budget">Daily Budget</label>
                        <input type="number"  class="form-control" required="required"  placeholder="Daily Budget" 
                        name="daily_budget" v-model="campaign.daily_budget" id="daily_budget">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total_budget">Total Budget</label>
                        <input type="number"  class="form-control" required="required"  placeholder="Total Budget" 
                        name="total_budget" v-model="campaign.total_budget" id="total_budget">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="from">Start From</label>
                        <input type="date"  class="form-control" required="required"  placeholder="Start From" name="from" id="from" v-model="campaign.from">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="to">Ends</label>
                        <input type="date"  class="form-control" required="required"  placeholder="Ends" name="to" id="to" v-model="campaign.to">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
    </div>
</template>
<script>
export default {
    
    data() {
        return {
            campaign:{
                name: '',
                daily_budget: '',
                total_budget: '',
                from: '',
                to: '',
                campaign_image: []
            }, 
            attachments: [],
            file: '',
            success: '',
            myFormData: new FormData()     
        }
        
    },

    methods: {
        /* onFileChange(e) {
            var input = document.getElementById('campaign_image');
            var file = input.files;
            this.campaign.campaign_image = file;
            console.log(this.campaign.campaign_image);
        },  */
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
        handleSubmit(e) {
            //var myFormData = new FormData(this.$refs.myForm);
            this.prepareFields();
            this.myFormData.append('name', this.campaign.name);
            this.myFormData.append('daily_budget', this.campaign.daily_budget);
            this.myFormData.append('total_budget', this.campaign.total_budget);
            this.myFormData.append('from', this.campaign.from);
            this.myFormData.append('to', this.campaign.to);
            axios({
                    method: 'post',
                    url: 'api/campaigns',
                    data: this.myFormData,
                    config: {
                        headers: { 'Content-Type': 'multipart/form-data' } ,
                        
                    }
                })          
            .then(res => res)
            .then(data => {
                if(data.err){
                    console.log(data);
                    alert(data.err);
                }else{
                    console.log(data);
                    alert('Campaign Added');
                    var check = confirm('Continue to Home page?');
                    if(check){
                        window.location='./';
                    }
                } 
            }).catch(
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