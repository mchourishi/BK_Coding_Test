import React, { Component } from 'react';
import axios from 'axios';
import './App.css';

class App extends Component {

  constructor(props) {
    super(props);
    this.state = {
      selectedFile: null,
      uploading: true
    };
    this.fileSelected = this.fileSelected.bind(this);
    this.fileUploaded = this.fileUploaded.bind(this);
  }
  //This is called when a file is selected and it validates the image type and its size.
  fileSelected(event) {
    console.log(event.target.files[0]);
    const file = event.target.files[0];
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
    const uploadedFileType = file.type;
    const uploadedFileSize = Math.round(file.size / 1024 / 1024);
    //Validate Type of File uploaded, should allow to only upload the image types
    //Restrict files of more than 1 MB size (1024 KB)
    if (!validImageTypes.includes(uploadedFileType || uploadedFileSize > 1)) {
      alert('Please upload only images of size not more than 1 MB.');
      this.setState({ selectedFile: null, uploading: false })
    } else {
      this.setState({ selectedFile: file, uploading: true })
    }
  }

  //It will call the php file and will upload the file.
  fileUploaded() {
    if (this.state.uploading) {
      console.log('Lets upload!!')
      const formData = new FormData();
      formData.append('image', this.state.selectedFile, this.state.selectedFile.name);

      //Send request to upload.php file with form data.
      axios.post('http://localhost:8080/CODE_CHALLENGE/backend/upload.php', formData
      ).then(res => {
        console.log(res);
      }
      );
    }
  }
  render() {
    return (
      <div className="App">
        <pre>{JSON.stringify(this.state)}</pre>
        <input type="file" onChange={this.fileSelected}></input>
        <button onClick={this.fileUploaded}>Upload</button>
      </div>
    );
  }
}

export default App;
