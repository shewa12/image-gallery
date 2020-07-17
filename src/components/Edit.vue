<template>
<v-row>
    <v-col cols="12" md="6" offset-md="3">
        <v-card  align="center" justify="center">

            <div>
            <img ref='img' crossOrigin="Anonymous" id='image' :src="image" class='img-fluid' :style='filters' >               
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
                      
                        <v-col cols="3" v-for='(preset,k) in presets()' @click='selectAndLoadPreset(preset)' :class="[(selectedPreset && (selectedPreset.name==preset.name)) ? 'bg-primary' : 'bg-secondary']" :key="k" class="d-flex child-flex">
                            
                          
                           <img :class="k=='default'? 'filter activeFilter' :'filter' " crossorigin="nnonymous" :src="image" @click="setFilterActive($event)" :style='makeFilter(preset.filterSet)' :title="k"> 
                                 
                        </v-col>                          
                     
                    </v-row>

                </v-tab-item>
                <!--filter end-->
                <!--adjust-->
                <v-tab-item>
                    <v-row>
                       
                        <v-col cols="6">
                            Grayscale ({{ filterFunctions.grayscale }})
                            
                            <input type="range" class="form-control" step='0.1' min="0" max="1" v-model='filterFunctions.grayscale' :disabled='!image'>
                            
                        </v-col>
                        <v-col cols="6">
                            <label>Blur ({{ filterFunctions.blur }}px)</label>
                            <input type="range" class="form-control" step='1' min="0" max="50" v-model='filterFunctions.blur' :disabled='!image'>
                        </v-col>
                        <v-col cols="6">
                            <label>Sepia ({{ filterFunctions.sepia }})</label>
                            <input type="range" class="form-control" step='0.1' min="0" max="1" v-model='filterFunctions.sepia' :disabled='!image'>
                        </v-col>
                        <v-col cols="6">
                            <label>Saturate ({{ filterFunctions.saturate }})</label>
                            <input type="range" class="form-control" step='0.1' min="0" max="2" v-model='filterFunctions.saturate' :disabled='!image'>
                        </v-col>
                        <v-col cols="6">
                            <label>Opacity ({{ filterFunctions.opacity }})</label>
                            <input type="range" class="form-control" step='0.1' min="0" max="1" v-model='filterFunctions.opacity' :disabled='!image'>
                        </v-col>
               
                    <v-col cols="6" :data-filter-disabled='!image'>
                        
                            <label>Brightness ({{ filterFunctions.brightness }})</label>
                            <input type="range" class="form-control" step='0.01' min="0" max="5" v-model='filterFunctions.brightness' :disabled='!image'>
                    </v-col>   
                    <v-col cols="6">
                        <label>Contrast ({{ filterFunctions.contrast }})</label>
                        <input type="range" class="form-control" step='0.01' min="0" max="10" v-model='filterFunctions.contrast' :disabled='!image'>
                    </v-col>
                    <v-col cols="6">
                        <label>Hue-rotate ({{ filterFunctions.hueRotate }}deg)</label>
                        <input type="range" class="form-control" step='1' min="-360" max="360" v-model='filterFunctions.hueRotate' :disabled='!image'>
                    </v-col>
                    <v-col cols="6">
                        <label>Invert ({{ filterFunctions.invert }})</label>
                        <input type="range" class="form-control" step='0.1' min="0" max="2" v-model='filterFunctions.invert' :disabled='!image'>
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
                                    <v-btn  v-for="(flip,k) in predefinedFlips" :key="k" outlined=""  :class="flip=='None'? 'mr-5 flip activeFlip': 'mr-5 flip' " @click="setFlip(flip,$event)" id="flipNone">{{flip}}</v-btn>

                                </span>
                            </v-col>
                            <v-col>
                                <span class="rotate">Rotate: </span> 
                                <span class="buttons">
                                    <v-btn v-for="(rotate,k) in predefinedRotations" :key="k" outlined="" :class="rotate==0? 'rotate activeRotate' :'rotate' " @click="setRotate(rotate,$event)"> {{rotate}}deg</v-btn>
                                  
                                </span>
                            </v-col>
                            <v-col>
                                <span class="crop">Ratio: Not Done :( </span> 
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

                <v-btn ref="save"  color="primary" @click="saveImage()" >
                    <span id="save">Save</span>
                </v-btn>
            </v-card-actions>                
    
        </v-card>

    </v-col>
</v-row>

</template>  <!--start--> 


<script>

const apiurl = "http://localhost/image-gallery/backend/index.php"; 

export default {
	name: 'edit',

	data() {
		return {
            image: '',
            rotate:'',
            flip:'',
            predefinedRotations:'',
            predefinedFlips:'',
			filterFunctions: null,
			width: 0,
			height: 0,
			selectedPreset: null,
			activeFilter:"default"
		}
	},
	created() {
		this.image = this.$route.params.file_url;
        this.filterFunctions = this.defaultValues();
        this.predefinedRotations = this.rotations();
        this.predefinedFlips = this.flips();
        this.getMeta();
	},

	computed: {
		filters() {
			return this.makeFilter();
		}
	},
	methods: {
        getMeta: function (){
        
            let url = this.$route.params.file_url;    
            let img = new Image();
            img.onload = async function(){
                document.querySelector("#image").setAttribute('data-original-width',this.width);
                document.querySelector("#image").setAttribute('data-original-height',this.height);
            };
            img.src = url;
          
/*
            this.width = width;
            this.height = height;
              alert(this.width+' '+this.height)
*/
        },      
        setFilterActive(event){
            let classes = document.getElementsByClassName('filter');
            for(let c of classes){c.classList.remove('activeFilter')}
            event.currentTarget.classList.add('activeFilter');             
        },  
		makeFilter(filterSet) {

            
			if(!filterSet) {
				filterSet = this.filterFunctions;
			}

			var filterString = "";
			var defaultValues = this.defaultValues();
			for (var filterFunc in filterSet) {
				if(filterSet[filterFunc] !== defaultValues[filterFunc]) {
					if(filterFunc == 'hueRotate') {
						filterString = filterString + "hue-rotate(" + filterSet[filterFunc] + "deg) ";
					}
					else if(filterFunc == 'blur') {
						filterString = filterString + filterFunc + "(" + filterSet[filterFunc] + "px) ";
					}
					else {
						filterString = filterString + filterFunc + "(" + filterSet[filterFunc] + ") ";
					}
				}
			}

			return {filter: filterString};
		},
		setToDefault() {
			this.filterFunctions = this.defaultValues();
		},
		defaultValues() {
			return {
				grayscale: 0,
				sepia: 0,
				saturate: 1,
				hueRotate: 0,
				invert: 0,
				brightness: 1,
				contrast: 1,
				blur: 0,
				opacity: 1
			}
		},


		presets() {
			return {
                default:{name: 'Brannes', filterSet: { contrast: 1}},
                grayscale: {name: 'Grayscale', filterSet: {grayscale: 2}},
                sepia: {name: 'Sepia', filterSet: {sepia: 1}},
				invert: {name: 'Invert', filterSet: {invert:1}},
				inkwell: {name: 'Inkwell', filterSet: {sepia: 0.3, contrast: 1.1, brightness: 1.1, grayscale: 1}},
				lofi: {name: 'Lo-Fi', filterSet: {saturate: 1.1, contrast: 1}},
				
				nashville: {name: 'Nashville', filterSet: {sepia: 0.2, contrast: 1, brightness: .7, saturate: 1.2}},
				
				walden: {name: 'Walden', filterSet: {brightness:1.1, hueRotate: '-5', sepia: .3, saturate: 1.6}},
				
				
			}
		},
		selectAndLoadPreset(preset) {
			if(preset) {
				this.filterFunctions = preset.filterSet;
				this.selectedPreset = preset;
			}
        },
        rotations(){
            return [0,30,60,90,180];
        },
        setRotate(r,event){
            this.rotate = r;
            let classes = document.getElementsByClassName('rotate');
            for(let c of classes){c.classList.remove('activeRotate')}
            event.currentTarget.classList.add('activeRotate');            
            document.querySelector("#image").style.webkitTransform = `rotate(${this.rotate}deg)`;
        },
        flips(){
            return ['None','Flip Horizontally','Flip Vertically'];
        },
        setFlip(flip,event){

            this.flip = flip;
            let classes = document.getElementsByClassName('flip');
            for(let c of classes){c.classList.remove('activeFlip')}
            event.currentTarget.classList.add('activeFlip');
            if(flip=="None")
            {
                document.querySelector("#image").style.webkitTransform = 'scale(1)';
            }
            if(flip=="Flip Horizontally")
            {
                document.querySelector("#image").style.webkitTransform = 'scaleX(-1)';
            }
            if(flip=="Flip Vertically")
            {
                document.querySelector("#image").style.webkitTransform = 'scaleY(-1)';
            }
            
        },
		saveImage() {
            var rotate = this.rotate;
            var flip = this.flip;
			const canvas = document.createElement('canvas');
			canvas.width = document.getElementById("image").getAttribute("data-original-width");
			canvas.height = document.getElementById("image").getAttribute("data-original-height");

			const ctx = canvas.getContext('2d');
            ctx.filter = this.filters.filter;

			var img = new Image();
            img.src = this.image;
            img.crossOrigin="anonymous";
			img.onload =  function() {
                ctx.drawImage(this, 0, 0, canvas.width, canvas.height)    
//rotate
            if(rotate)
            {
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.save();
                ctx.translate(canvas.width/2,canvas.height/2);
                ctx.rotate(rotate*Math.PI/180);
                ctx.drawImage(img,-img.width/2,-img.width/2);
                ctx.restore();                
            }
//rotate end 

//flip
          
            if(flip =="Flip Horizontally"){
               
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.save();
                ctx.scale(-1, 1); // Set scale to flip the image
                ctx.drawImage(img, -img.width,0,img.width,img.height);
                
                ctx.restore(); // Restore the last saved state
            }
            if(flip =="Flip Vertically"){
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.save();
                ctx.scale(1, -1); // Set scale to flip the image
                ctx.drawImage(img, 0, -img.height, img.width, img.height); // draw the image
                ctx.restore(); // Restore the last saved state                
            }
            


//flip end
                canvas.toBlob(async function(blob){
                document.querySelector("#save").innerHTML = 'Saving ...';
                let form = new FormData();
                form.append('file',blob,'image-modified.jpg');
                let post = await fetch(apiurl,{
                method:'post',
                body: form
                });
                if(post.ok)
                {
                let response = await post.json();
                    document.querySelector("#save").innerHTML = 'Saved';
                    console.log('success'+ response);
                }
                else
                {
                    console.log(`Status ${post.status} Error: ${post.statusText}`);
                }                  
            },"image/jpeg", 1);
			};
		},

	}
}

</script>

<style>
pre{
	color: rgb(76, 186, 135);
	font-size: 18px;
	font-weight: bolder;
}
.filter {
    cursor: pointer;
}
.activeFilter,.activeRotate,.activeFlip {
    border: 2px solid lightblue;
}
input[type=range] {
	padding: 0;
	border: none;
}


</style>
