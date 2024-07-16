<template>
    <!-- forms page -->
    <div class="col-12 my-2" v-if="this.$route.query.page === 'forms'">
        <div class="w-100 d-block">
              <h4>files</h4>
        </div>
        <div class="d-block">
            <div class="btn-group d-block" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck1">file 1 </label>

            <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck2">file 2 </label>

            <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck3">file 3 </label>
            </div>
        </div>
    </div>
     <!-- recent page -->
    <div v-if="this.$route.query.page === 'recent'">
        <div class="col-12 my-2">
            <h4>Today</h4>
        </div>
        <div class="col-12 d-flex ">
            <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck1">file 1 </label>

            <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck2">file 2 </label>

            <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck3">file 3 </label>
            </div>
        </div>
        <div class="col-12 my-2">
            <h4>last Week</h4>
        </div>
        <div class="col-12 d-flex">
            <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="btncheck5" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck5">file 1 </label>

            <input type="checkbox" class="btn-check" id="btncheck6" autocomplete="off">
            <label class="btn btn-outline-primary file-box me-2" for="btncheck6">file 2 </label>

            
            </div>
        </div>
    </div>
     <!-- upload page -->
    <div v-if="this.$route.query.page === 'upload'">
        <div class="col-12 my-2">
            <h4>{{this.$route.query.page}}</h4>
        </div>
        <div class="d-flex justify-content-center">
            <img src="../assets/upload_background.png" class="text-center d-block upload-img" alt="background">
            
        </div>
        <div class="d-flex justify-content-center">
                <label class="btn btn-primary" for="file-id">Browse</label>
                <input type="file" id="file-id" class="d-none">
            </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>
 @media (max-width : 600px) {
      
    .btn.btn-outline-primary.file-box{
            flex-wrap: wrap !important;
            flex-direction: column !important;

         }
         .upload-img{
            width: 100% !important;
         }
    }
</style>