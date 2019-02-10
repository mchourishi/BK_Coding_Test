# Bruel & Kjaer Coding Challenge!!

This is coding challenge from "Bruel and Kjaer" and it includes a Backend and Frontend Test.

## Instructions
First clone this repository.
```bash
$ git clone https://github.com/mchourishi/BK_Coding_Test.git
```
Change Directory to frontend
```bash
$ cd frontend
```
Install dependencies . Make sure you already have [`nodejs`](https://nodejs.org/en/) & [`npm`](https://www.npmjs.com/) installed in your system and you are in frontend
```bash
$ npm install # or yarn
```

## Introduction : Backend 
Its a Command Line script that asks for first and the last name and then asks for email and validates email with RegEx,
it also asks for address and validates the address with the Google Maps API.If everything seems alright, it will greet the user.

## Instructions : Backend
1. Execute `php UserInfo.php` from command line after changing directory to `backend`.
2. Enter first and last name when prompted.
3. Enter Email in valid email format.
4. Enter your correct address which is also validated through the geocoding api.
5. If email and address both are correct greet the user.

## Screenshot : Backend

<img src="https://github.com/mchourishi/BK_Coding_Test/blob/master/screenshots/backend-php-cli.png" />

## Introduction : Frontend
The frontend is a single page react file uploader script.
It asks for a image to be uploaded in a valid format.
Once uploaded, will show the image in a thumbnail and will also show the mirrored image of the original image.
All the frontend stuff is in the `frontend` directory.

## Instructions : Frontend
1. cd to frontend
2. Run it ```bash $ npm start # or yarn start```
3. Upload image in a valid format.
4. Press the upload button.
5. Images will be uploaded in `frontend/images` directory, file upload.php in backend serves the uploaded file.
5. Once uploaded will show the uploaded image in a thumbnail.
5. And a horizontal mirrored image under the thumbnail.

## Screenshot : Frontend

<img src="https://github.com/mchourishi/BK_Coding_Test/blob/master/screenshots/frontend-thumbnail-mirrorimage.png" />


