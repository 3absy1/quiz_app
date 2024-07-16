<template>
    <div>
       
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
            <div class="modal-dialog modal-width" >
                <div class="modal-content">
                <div class="modal-header row pb-0 border-0">
                    <div class="col-12 d-flex align-items-center">
                        <h1 class="modal-title fs-5 col-6 mb-3" id="staticBackdropLabel" v-if="$route.query.type === 'question'">Select Form</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="event=>this.$router.push({name : 'home'})"></button>
                    </div>
                    <div class="col-12 border-1 border-bottom">
                        <ul class="d-flex ps-0 mt-2" style="list-style: none;" v-if="$route.query.type == 'question'">
                            <li class="me-2"> <router-link :class="$route.query.page == 'forms' ? 'text-black fw-bolder': ''" :to="{name:'popup',query:{type:'question',page:'forms'}}">Forms</router-link>  </li>
                            <li class="me-2"> <router-link :class="$route.query.page == 'recent' ? 'text-black fw-bolder': ''" :to="{name:'popup',query:{type:'question',page:'recent'}}">Recent</router-link></li>
                        </ul>
                       
                    </div>
                </div>
                <!-- modal body  -->
                <div class="modal-body">
                    <form class="row border-bottom border-1 pb-3" role="search">
                        <div class="d-flex col-lg-6">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </div>
                        <div class="d-flex justify-content-end mt-3 mt-md-0 col-lg-6">
                            <button class="btn btn-secondary" v-tippy="{ content: 'List View', placement: 'top' }"><span v-html="listIcon"></span></button>
                            <button class="btn btn-secondary  ms-2" v-tippy="{ content: 'Sort Option', placement: 'top' }"><span v-html="azIcon"></span></button>
                        </div>
                    </form>

                <!-- nested Route -->
                    <div class="row">
                        <RouterView />
                    </div>

                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-primary">select</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="event=>this.$router.push({name : 'home'})">Close </button>

                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'pinia';
import { svgIcons } from './icons/SvgIcons';
import { formStore } from '../stores/formStore';
import { RouterLink, RouterView } from 'vue-router';

    export default {
        data(){
            return{
                listIcon:svgIcons.list,
                azIcon:svgIcons.az,
                
            }
        },
        components:{
            RouterLink,
            RouterView
        },
        computed:{
            ...mapState(formStore,['modalType'])
        },
        
    }
</script>

<style>
    .modal-width {
    max-width: 1200px !important;
    width: 100%;
    }
    .file-box{
        border: 1px solid #ced4da;
        border-radius: 10px !important;
        padding: 5px;
        margin-bottom: 8px;
        display: flex;
        flex: wrap !important;
        cursor: pointer;
        width: 120px;
        text-align: center;
        justify-content: center;
        align-items: center;
        height: 150px;
    }
    @media (max-width : 600px) {
        .modal-width{
            max-width:500px !important;
            width: 100%;
        }
    }

</style>