import React, { Component } from 'react';
import axios from 'axios';
import './App.css';

class App extends Component {

  constructor(props) {
    super(props);
    this.state = {
      selectedFile: null,
      validFile: true,
      uploaded: false,
      thumbnailUrl: null
    };
    this.fileSelected = this.fileSelected.bind(this);
    this.fileUploaded = this.fileUploaded.bind(this);
    this.showThumbnail = this.showThumbnail.bind(this);
    this.showMirrorImage = this.showMirrorImage.bind(this);
  }
  //This is called when a file is selected and it validates the image type and its size.
  fileSelected(event) {
    let file = event.target.files[0];
    //Validate Type of File uploaded, should allow to only upload the image types
    //Restrict files of more than 1 MB size (1024 KB)
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
    let uploadedFileType = file.type;
    let uploadedFileSize = Math.round(file.size / 1024 / 1024);
   
    if (!validImageTypes.includes(uploadedFileType) || uploadedFileSize > 1) {
      alert('Please upload only images of size not more than 1 MB.');
      this.setState({ selectedFile: null, validFile: false })
    } else {
      this.setState({ selectedFile: file, validFile: true })
    }
  }

  //It will call the php file and will upload the file.
  fileUploaded() {
    if (this.state.validFile) {
      let formData = new FormData();
      formData.append('image', this.state.selectedFile, this.state.selectedFile.name);

      //Send request to upload.php file with form data.
      axios.post('http://localhost:8080/CODE_CHALLENGE/backend/upload.php', formData
      ).then(res => {
        this.setState({
          selectedFile: this.state.selectedFile,
          uploaded: true
        });
        this.showThumbnail();
        this.showMirrorImage();
      }
      );
    }
  }

  //Displays thumbnail after successful upload of image.
  showThumbnail() {
    if (this.state.selectedFile != null) {
      let file = this.state.selectedFile;
      let reader = new FileReader();
      reader.onloadend = () => {
        this.setState({
          selectedFile: file,
          thumbnailUrl: reader.result
        });
      }
      reader.readAsDataURL(file);
    }
  }

  //Display Mirrored Image along X-axis after upload of image.
  showMirrorImage() {
    const canvas = this.refs.canvas;
    const ctx = canvas.getContext('2d');
    let file = this.state.selectedFile;
    var reader = new FileReader();
    reader.onload = function(event){
        let img = new Image();
        let width = 500,
        height = 200,
        posX =  width * -1 ; // Set x position to -100% if flip horizontal  

        img.onload = function(){
          ctx.translate(0, 0)
          ctx.scale(-1, 1)
          ctx.drawImage(img, posX, 0,width,height)
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(file);   
  }

  render() {
    //Show Thumbnail only after the image is successfully uploaded!
    let $imageElement = "";
    if (this.state.uploaded === true && this.state.thumbnailUrl != null) {
      $imageElement = (<img src={this.state.thumbnailUrl} height="200" width="500" alt="Thumbnail..." />);
    }
    return (
      <div className="App">
        {/* <pre>{JSON.stringify(this.state)}</pre> */}
        <input type="file" onChange={this.fileSelected}></input>
        <button className = "button" onClick={this.fileUploaded}>Upload Image</button>
        <div>
          {$imageElement}
        </div>
        <div><canvas id="canvas" ref="canvas" width="500" height="200"></canvas></div>

      </div>
    );
  }
}

export default App;
