<template>

    <div>
        
        <h3>
            Available Campaigns
        </h3>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="javascript:void(0)" @click="fetchCampaigns(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="javascript:void(0)">
                        Page {{ pagination.current_page }} of {{ pagination.last_page }}
                    </a>
                </li>

                <li v-bind:class="[{ disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="javascript:void(0)" @click="fetchCampaigns(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <!-- Button trigger modal -->

        <div class="card card-body mb-2" v-for="campaign in campaigns" v-bind:key="campaign.id">
            <h3> {{ campaign.name }}</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3" v-for="campaign_image in campaign.campaign_image.split('||')" v-if="campaign_image!=''"  v-bind:key="campaign_image">
                            <img  :src="'storage/campaign_images/'+campaign_image" class="rounded float-start mb-3 center" 
                                    style="width:100%" :alt="campaign.name" > 
                        </div>
                    </div>

                    <!-- <img :src="'storage/campaign_images/'+campaign.campaign_image" class="rounded float-start mb-3" 
                    style="width:300px" :alt="campaign.name" > -->
                    
                </div>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Daily Budget:</th>
                                <td>${{ campaign.daily_budget }}</td>
                                <th>Total Budget:</th>
                                <td>${{ campaign.total_budget }}</td>
                            </tr>
                            <tr>
                                <th>Start Date:</th>
                                <td>${{ campaign.from }}</td>
                                <th>End Date:</th>
                                <td>${{ campaign.to }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <!-- Button trigger modal -->
                    <button type="button" @click="previewCampaign(campaign)" class="btn btn-primary mb-2" data-bs-toggle="modal" :data-bs-target="'#modal'+PageModal.id" >
                        Preview
                    </button>
                    <a :href="'edit-campaign/?id='+ campaign.id " class="btn btn-primary  mb-2" style=" display: none">
                        Edit 
                    </a>
                    <button @click="deleteCampaign(campaign.id, pagination.current_page)" class="btn btn-danger btn-md mb-2">
                        Delete
                    </button>
                    
                </div>
            </div>    
        </div>
        <!-- Modal -->
        <PreviewCampaign :PageModal="PageModal"/>
    </div>
</template>
<script>
import PreviewCampaign from '../components/PreviewCampaign.vue';
export default {
    components: {
        PreviewCampaign
    },
    data() {
        return {
            campaigns:[],
            campaign:{
                id: '',
                name: '',
                daily_budget: '',
                total_budget: '',
                from: '',
                to: '',
                campaign_image: ''
            }, 
            campaign_id: '',
            pagination: {},
            edit: false ,
            PageModal:{
                id: '',
                name: '',
                daily_budget: '',
                total_budget: '',
                from: '',
                to: '',
                campaign_image: ''
            },           
        }
        
    },

    created(){
        this.fetchCampaigns();
    },

    methods: {        
        fetchCampaigns(page_url){
            let vm = this;
            page_url = page_url || 'api/campaigns';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.campaigns = res.data;
                vm.makePagination( res.meta, res.links);
            })
            .catch(err => console.log(err));
        },
        makePagination(meta, links){
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        },
        deleteCampaign(id, current_page){
            if(confirm('Are you sure?')){
                fetch(`api/campaign/${id}`, {
                    method: 'delete',
                })
                .then(res => res.json())
                .then( data => {
                    alert('Campaign removed');
                    //console.log(data);
                    this.fetchCampaigns(`api/campaigns?page=`+current_page);
                })
                .catch(err => console.log(err));
            }
        },
        previewCampaign(campaign){
            this.PageModal.id = campaign.id;
            this.PageModal.name = campaign.name;
            this.PageModal.daily_budget = campaign.daily_budget;
            this.PageModal.total_budget = campaign.total_budget;
            this.PageModal.from = campaign.from;
            this.PageModal.to = campaign.to;
            this.PageModal.campaign_image = campaign.campaign_image; //campaign.campaign_image;
        }
    }
}
</script>
