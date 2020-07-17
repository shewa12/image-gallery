<template>
<v-row>
    <v-col cols="12" md="6" offset-md="3">
        <v-card  align="center" justify="center">

            <div>
            <img ref='img' crossOrigin="Anonymous" id='image' :src="image" class='img-fluid' :style='filters' data-original-width='760' data-original-height='476'>               
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
                            
                          
                           <img  crossorigin="nnonymous" :src="image" class='' :style='makeFilter(preset.filterSet)' :title="k"> 
                                 
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

                            </v-col>
                            <v-col>
                                <span class="rotate">Rotate: </span> 

                            </v-col>
                            <v-col>
                                <span class="crop">Ratio: </span> 


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

                <v-btn  color="primary" @click="download()">Save</v-btn>
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
			filterFunctions: null,
			width: 0,
			height: 0,
			selectedPreset: null,
			textCopied: false
		}
	},
	created() {
		this.image = this.$route.params.file_url;
        this.filterFunctions = this.defaultValues();
       
	},
	watch: {
		textCopied() {
			setTimeout(function() {
				if(this.textCopied == true) {
					this.textCopied = false;
				}
			}.bind(this), 350);
		}
	},
	computed: {
		filters() {
			return this.makeFilter();
		}
	},
	methods: {
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
		changeImage(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;

			this.loadImage(files[0]);
		},
		loadImage(file) {
			var reader = new FileReader();
			var image = new Image();

			reader.onload = (e) => {
				this.image = e.target.result;
				image.src = e.target.result;
			};
			reader.readAsDataURL(file);
			image.onload = function() {
				document.getElementById("image").setAttribute("data-original-width", this.width);
				document.getElementById("image").setAttribute("data-original-height", this.height);
			}
		},
		presets() {
			return {
                defualt:{name: 'Brannes', filterSet: { contrast: 1}},
                grayscale: {name: 'Grayscale', filterSet: {grayscale: 2}},
                sepia: {name: 'Sepia', filterSet: {sepia: 2}},
				invert: {name: 'Invert', filterSet: {invert:1}},
				inkwell: {name: 'Inkwell', filterSet: {sepia: 0.3, contrast: 1.1, brightness: 1.1, grayscale: 1}},
				lofi: {name: 'Lo-Fi', filterSet: {saturate: 1.1, contrast: 1.5}},
				moon: {name: 'Moon', filterSet: {grayscale: 1, contrast: 1.1, brightness: 1.1}},
				nashville: {name: 'Nashville', filterSet: {sepia: 0.2, contrast: 1.2, brightness: 1.05, saturate: 1.2}},
				toaster: {name: 'Toaster', filterSet: {contrast: 1.5, brightness: 0.9}},
				walden: {name: 'Walden', filterSet: {brightness:1.1, hueRotate: '-10', sepia: .3, saturate: 1.6}},
				
				
			}
		},
		selectAndLoadPreset(preset) {
			if(preset) {
				this.filterFunctions = preset.filterSet;
				this.selectedPreset = preset;
			}
		},
		download() {
			const canvas = document.createElement('canvas');
			canvas.width = document.getElementById("image").getAttribute("data-original-width");
			canvas.height = document.getElementById("image").getAttribute("data-original-height");

			const ctx = canvas.getContext('2d');
            ctx.filter = this.filters.filter;
       
			var img = new Image();
            img.src = this.image;
            img.crossOrigin="anonymous";
            
			img.onload = async function() {
                ctx.drawImage(this, 0, 0, canvas.width, canvas.height)
            canvas.toBlob(async function(blob){
                let form = new FormData();
                form.append('image',blob,'image-modified.jpg');
                let post = await fetch(apiurl,{
                method:'post',
                body: form
                });
                if(post.ok)
                {
                let response = await post.json();
                alert(JSON.stringify(response));
                }
                else
                {
                console.log(`Status ${post.status} Error: ${post.statusText}`);
                }                  
            },"image/jpeg", 1);
                
/*
				const anchor = document.createElement('a');
				anchor.href = canvas.toDataURL();
				anchor.download = 'filtered.png';
				anchor.click();
*/
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

input[type=range] {
	padding: 0;
	border: none;
}

[data-filter-disabled=true],
button[disabled=true],
button[disabled=disabled],
[data-filter-disabled=true] input {
	background: #f1f1f1;
	cursor: not-allowed;
}

#copy-code{ position: relative; }
#copy-code .btn{
	position: absolute;
	top: 0;
	right: 0;
}
.card-presets > .card-body{
	/*
	height: 540px;
	overflow-y: auto;
	*/
}

#image {
	transition: 0.6s;
	max-height: 400px;
}
.card-presets .card,
.card-presets {
	border-radius: 0;
}
.card-presets {
	width: 100%;
	/*
	position: fixed;
	bottom: 0;
	left: 0;
	z-index: 10000;
	*/
}
.card-presets .card {
	transition: 0.3s;
}
.card-presets .card > .card-body {
	overflow: hidden
}
.card-presets img {
	max-height: 50px;
}

 .owl-nav .owl-prev,
 .owl-nav .owl-next {
	position: absolute;
	top: 0;
	bottom: 0;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 40px;
	z-index: 1;
	text-align: center;
	background: rgba(52, 58, 64, 0.75);
}

.owl-nav .owl-next {
	right: 0
}
.owl-nav .owl-prev {
	left: 0;
}
.owl-carousel .owl-item img {
	width: auto !important;
	margin: auto;
	height: 100px;
}

.owl-nav > .disabled {
	color: #aaa;
}
</style>
