<template>
<v-row>
    <v-col cols="12" md="6" offset-md="3">
        <v-card  align="center" justify="center">

            <div>
            <img 
            class="white--text" :class="filter+' '+rotate+' '+flip+' '+ratio" :src="$route.params.file_url"
            />                
            </div>
            <v-card-text class="text--primary">
        <!--tab-->
  
            <v-tabs :centered="true" :grow="true">
                <v-tab>Filter</v-tab>
                <v-tab>Adjust</v-tab>
                <v-tab>Crop</v-tab>
                <!--filter-->
                <v-tab-item>
                    <v-row>
                      
                    <v-col
                        v-for="(filter,k) in filters"
                        :key="k"
                        class="d-flex child-flex"
                        cols="3"
                        
                      >
                     
                        <img cols="12" :src="$route.params.file_url" alt="image" :class="k==0 ? filter+' '+'activeFilter' :filter" aspect-ratio="2" @click="setFilter">
                       
                    </v-col>
                        
                    </v-row>

                </v-tab-item>
                <!--filter end-->
                <!--adjust-->
                <v-tab-item>
                    <v-row>
                        <v-col cols="12">
                            Crop
                        </v-col>
                    </v-row>
                </v-tab-item>
                <!--adjust-->
                <!--crop-->
                <v-tab-item>
                    <v-row>
                        <v-col cols="12">
                            <v-col>
                                <span class="flip">Flip: </span> 
                                <span class="buttons">
                                    <v-btn outlined=""  class="mr-5 flip flipActive" @click="setFlip" id="flipNone">None</v-btn>
                                    <v-btn outlined="" class="mr-5 flip" @click="setFlip" id="flipHorizontal">Horizontally</v-btn>
                                    <v-btn outlined="" class="flip" @click="setFlip"   id="flipVertical">Vertically</v-btn>
                                </span>
                            </v-col>
                            <v-col>
                                <span class="rotate">Rotate: </span> 
                                <span class="buttons">
                                    <v-btn outlined="" class="rotate activeRotate" @click="setRotate" id="rotate0deg">0 deg</v-btn>
                                    <v-btn outlined="" class="rotate " @click="setRotate" id="rotate30deg">30 deg</v-btn>
                                    <v-btn outlined="" class="rotate " @click="setRotate" id="rotate60deg">60 deg</v-btn>
                                    <v-btn outlined="" class="rotate " @click="setRotate" id="rotate90deg">90 deg</v-btn>
                                    <v-btn outlined="" class="rotate " @click="setRotate" id="rotate180deg">180 deg</v-btn>                                    
                                </span>
                            </v-col>
                            <v-col>
                                <span class="crop">Ratio: </span> 
                                <span class="buttons">
                                    <v-btn outlined="" color="primary">16:9</v-btn>
                                    <v-btn outlined="" color="primary">10:7</v-btn>
                                    <v-btn outlined="" color="primary">7:5</v-btn>
                                    <v-btn outlined="" color="primary">4:3</v-btn>
                                    <v-btn outlined="" color="primary">5:3</v-btn>
                                    <v-btn outlined="" color="primary">3:2</v-btn>                                    
                                </span>

                            </v-col>
                        </v-col>
                    </v-row>

                </v-tab-item>
                <!--crop-->


            </v-tabs>     
        <!--tab end-->
            </v-card-text>


            <v-card-actions align="right">
                <v-btn  color="" :to="{name:'app-gallery'}">Back</v-btn>

                <v-btn  color="primary">Save</v-btn>
            </v-card-actions>                
    
        </v-card>

    </v-col>
</v-row>

</template>       
<script>

  export default {
    data () {
      return {
        
          filter:"original",
          filters :['original','grayscale','sepia','invert','duotone','warm','cool','dramatic'],
          rotate:"rotate0deg",
          flip:"flipNone",
          ratio:"ratio16",
      }
    },
    created:function(){
        console.log(this.$route)
    },
    methods:{
        setFilter: function(e){
            //this.filter = filter;
            let classes = document.getElementsByClassName('activeFilter');
            for(let c of classes)
            {
               c.classList.remove('activeFilter')
            }
            e.currentTarget.classList.add('activeFilter')
            this.filter =  e.currentTarget.classList[0];
            
        },
        setRotate: function(e){
            //this.filter = filter;
            let classes = document.getElementsByClassName('rotate');
            for(let c of classes)
            {
               c.classList.remove('activeRotate')
            }
            e.currentTarget.classList.add('activeRotate')
            this.rotate = e.currentTarget.getAttribute('id');
            
        },
        setFlip: function(e){
            //this.filter = filter;
            let classes = document.getElementsByClassName('flip');
            for(let c of classes)
            {
               c.classList.remove('flipActive')
            }
            e.currentTarget.classList.add('flipActive')
            this.flip =  e.currentTarget.getAttribute('id');
            
        }
    }
  }
</script>
<style scoped>

    .flip {
        margin-right: 20px;
    }
    .crop {
        margin-right: 10px;
    }
    .activeFilter {
        border: 3px solid tomato;
    }
.grayscale {
    -webkit-filter: grayscale(100%);
    filter: grayscale(100%);
}    
.sepia {
    -webkit-filter: sepia(100%);
    filter: sepia(100%);
}    
.invert {
    -webkit-filter: invert(100%);
    filter: invert(100%);
}    
.duotone {
    -webkit-filter: blur(1px);
    filter: blur(1px);
}    
.warm {
    -webkit-filter: brightness(.7);
    filter: brightness(.7);
}    
.cool {
    -webkit-filter: contrast(180%);
    filter: contrast(180%);
}    
.dramatic {
    -webkit-filter: hue-rotate(210deg);
    filter: hue-rotate(210deg);
} 
.activeRotate, .flipActive{
    border-color: #1976d2 !important;
}   
.rotate0deg {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
}
.rotate30deg {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
}
.rotate60deg {
    -webkit-transform: rotate(60deg);
    transform: rotate(60deg);
}
.rotate90deg {
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
}
.rotate180deg {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}
.flipNone {
   
}
.flipHorizontal {
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}
.flipVertical {
  -webkit-transform: scaleY(-1);
  transform: scaleY(-1);
}
</style>