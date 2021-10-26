<template>
<div>
    <div class="modal fade" :id="'modal'+PageModal.id" data-bs-backdrop="static" data-bs-keyboard="false" 
            tabindex="-1" :aria-labelledby="'modal'+PageModal.id+'Label'" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" :id="'modal'+PageModal.id+'Label'">{{ PageModal.name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span v-for="campaign_image in PageModal.campaign_image.split('||')" v-bind:key="campaign_image">
                            <img  :src="'storage/campaign_images/'+campaign_image" class="rounded float-start mb-3 center" 
                            style="width:300px;" :alt="PageModal.name"  v-if="campaign_image!=''" > 
                    </span>
                    
                    <br/><br/>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Daily Budget:</th>
                                <td>${{ PageModal.daily_budget }}</td>
                                <th>Total Budget:</th>
                                <td>${{ PageModal.total_budget }}</td>
                            </tr>
                            <tr>
                                <th>Start Date:</th>
                                <td>${{ PageModal.from }}</td>
                                <th>End Date:</th>
                                <td>${{ PageModal.to }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a :href="'edit-campaign/?id='+ PageModal.id " class="btn btn-primary">
                        Edit 
                    </a>
                </div>
                </div>
            </div>
        </div>
</div>
    <!-- Modal -->
        
</template>
<script>
export default {
    
    data() {
        return {
                      
        }
        
    },
    props:{
        PageModal:{},
    },

    created(){
    },
    name: "PreviewCampaign",

    methods: {
        /* previewCampaign(campaign){
            this.PageModal.id = campaign.id;
            this.PageModal.name = campaign.name;
            this.PageModal.daily_budget = campaign.daily_budget;
            this.PageModal.total_budget = campaign.total_budget;
            this.PageModal.from = campaign.from;
            this.PageModal.to = campaign.to;
            this.PageModal.campaign_image = campaign.campaign_image; //campaign.campaign_image;
        } */
    }
}
</script>
