          <template id="app">
            <v-row>
              <v-col cols="12" sm="6" offset-sm="3">
                <v-card>
                  <v-container fluid>
                    <v-row v-if="images.length">
                      <v-col
                        v-for="(image,k) in images"
                        :key="k"
                        class="d-flex child-flex"
                        cols="4"
                      >
                        <v-card flat tile class="d-flex">
                          <v-img 
                            :src="image.file_url"
                            :lazy-src="`https://picsum.photos/10/6?image=${k * 5 + 10}`"
                            aspect-ratio="1"
                            class="grey lighten-2" @click="edit(image.file_url)"
                          >
                            
                            <template v-slot:placeholder>
                              <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                              >
                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                              </v-row>
                            </template>
                          </v-img>

                        </v-card>
                      </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row>
                      <v-col  class="light-blue lighten-4">
                        <v-card-actions>
                              <vue-dropzone ref="dropzone"  :options="dropzoneOptions" v-on:vdropzone-success="uploadSuccess" v-on:vdropzone-error="uploadError" v-on:vdropzone-canceled="cancel" id="dropzone" :useCustomSlot=true>
                              <div class="dropzone-custom-content">
                                <h3 class="dropzone-custom-title"><i class='fa fa-cloud-upload'></i> Drag and drop or browse for image</h3>
                               
                              </div>
                            </vue-dropzone>                     

                        </v-card-actions> 
                      </v-col>
                     
                    </v-row>
                  </v-container>
                </v-card>
              </v-col>
            </v-row>
          </template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    const apiurl = "http://localhost/image-gallery/backend/index.php"; 

    export default {
     components: {

        vueDropzone: vue2Dropzone

      },
      data: function() {
        return {
          dropzoneOptions: {
              url: apiurl,
              acceptedFiles:'image/jpeg,image/png,image/gif',
              resizeWidth:760,
              resizeHeight:476
          },  

          images : []
        }
      },
      created: function(){
        this.gallery();
       
      },
      methods: {
      
        gallery: async function(){
        
          let form = new FormData();
          form.append('getimages','images');
          let post = await fetch(apiurl,{
            method:'post',
            body: form
          });
          if(post.ok)
          {
          let response = await post.json();
          if(response.length !==undefined)
          {
            this.images = response;
   
          }
          }
          else
          {
            console.log(`Status ${post.status} Error: ${post.statusText}`);
          }
          
        },
        edit:function(file_url){
          this.$router.push({ name: 'app-edit', params: { file_url: file_url }});
        },

        uploadSuccess:function(file,response) {
          this.images.push(JSON.parse(response))
          console.log(this.images)
          this.$refs.dropzone.removeAllFiles()
        },
        cancel:function(){
          alert('File uplaod canceled');
        },
        uploadError:function(){
          alert('File type invalid or something went wrong');
          this.$refs.dropzone.removeAllFiles()
        }
      }
    }
</script>         
<style scoped>
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
#dropzone{
  width: 100%;
}

</style>