<template>
    <nav>
        <h1>Technical Assignment  </h1>
    </nav>
    <span class="des">
         600x400 pixels
    </span>
  <div class="container d-flex">

      <canvas ref="canvas" id="canvas">

      </canvas>
      <div class="buttons">
          <input  ref="fileInputImage" class="custom-image-input" type="file" id="image" @input="readFileImage()">
          <input ref="fileInputBackground" class="custom-background-input" type="file" id="background" @input="readFileBackground()">
          <button type="button" class="download"  @click="download">Download</button>
          <button type="button" class="save"  @click="save">Save</button>
      </div>
  </div>

</template>

<script>
export default {

    data () {
        return {
            canvas:null,
            context:null,
            newImage: null,
            inputImage:null,
            canvasUrl:null,
            createEl:null,
            bodyFormData:null

        }
    },
    mounted() {
              this.canvas = this.$refs.canvas
              this.context = this.canvas.getContext('2d')
              this.inputImage = this.$refs.fileInputImage
              this.inputBackground = this.$refs.fileInputBackground
              this.newImage = new Image()
              this.createEl = document.createElement('a');
              this.bodyFormData = new FormData();
    },
    methods:{
        // read image and start to draw it
        readFileImage(){



            if (this.inputImage.files && this.inputImage.files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                     this.drawImage(e.target.result , 'image');

                }
                reader.readAsDataURL(this.inputImage.files[0])
                this.$emit('input', this.inputImage.files[0])

            }
        },
        // read background and start to read it
        readFileBackground(){
            if (this.inputBackground.files && this.inputBackground.files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                    this.drawImage(e.target.result , 'background');

                }
                reader.readAsDataURL(this.inputBackground.files[0])
                this.$emit('input', this.inputBackground.files[0])

            }
        },
        // draw image and background at canvas
        drawImage(file , type){

            this.newImage.src = file
            this.newImage.onload = () => {
                // Draw the image onto the context
                if(type == 'image'){
                    this.context.drawImage(this.newImage, 100,10 , 100 , 100);
                }else{
                    this.context.drawImage(this.newImage, 0,0 , 300 , 150);

                }


            }
        },//end of draw
        // download canvas
        download(){

            this.createEl.href = this.canvas.toDataURL();
            this.createEl.download = "download-canvas";
            this.createEl.click();
            this.createEl.remove();
        },
        // save canvas at database
        save(){
            canvas.toBlob( (blob)=> {
                this.bodyFormData.append('image', blob , 'vero.png');
                // axios post request
                axios({
                    method: 'post',
                    url: 'save/images',
                    data: this.bodyFormData,

                })
                    .then( (response)=> {
                        console.log(response.data[0])

                        Swal.fire({
                            title: 'Success!',
                            text: response.data[0],
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        })

                    })
                    .catch(function (error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Cannot Save Image',
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        })
                    });

            });//end bold


        }//end of draw
    }
}
</script>

<style scoped>
/** navbar **/
nav{
    background: #363636;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #FFF;
}
/** start description of canvas dimension */
.des{
    text-align: center;
    display: block;
    margin-bottom: -53px;
    margin-top: 100px;
    font-size: 12px;
    font-weight: bold;
    color: #5c4343;
}
/** start container **/
 .container{
     max-width: 900px;
     margin: 70px auto;

 }
 .d-flex{
     display: flex;

 }
 /** canvas styling **/
 .container canvas{
     width: 600px;
     height: 400px;
     border: 1px solid #CCC;
 }
 .container canvas .image{
     width: 200px;
     height: 200px;
     background: red;
 }
/** buttons box **/
 .buttons{
     display: flex;
     flex-direction: column;
     justify-content: center;
     padding: 0 10px;
     align-items: center;
 }
 /** create custom upload button **/
 .custom-image-input , .custom-background-input{
     position: relative;
     margin:20px  0 10px 0;
     height: 50px;

 }
 .custom-image-input::-webkit-file-upload-button , .custom-background-input::-webkit-file-upload-button{
     visibility:hidden
 }
 .custom-image-input::before , .custom-background-input::before {
     position: absolute;
     border: 1px solid #CCC;
     border-radius: 3px;
     cursor: pointer;
     background: #5483d7;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     color: #FFF;
     display: flex;
     align-items: center;
     justify-content: center;

 }
 .custom-image-input::before{
     content: 'Select Image';
 }
 .custom-background-input::before{
     content: 'Select Background';

 }
 .buttons .download ,  .buttons .save{
     border: 1px solid #CCC;
     border-radius: 3px;
     cursor: pointer;

     padding: 7px 15px;
     color: #FFF;
     margin:20px  0 10px 0;
 }
 .buttons .download{
     background:#d75454;
 }
 .buttons .save{
     background: #33a53c;
 }

</style>
