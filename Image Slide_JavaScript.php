<html>
 <!--
  Description: The script aims to perform the presentation of images over the network.
  Date: 16/04/2020
  Author: Alan de Freitas
 -->
 <head>
  <title>Images Slide</title>
  <style type="text/css">
   body
   {
    background-color: black;
   }
   img
   {
    position: absolute;/*Use the screen as a reference*/
    border: thin silver solid;
    max-width: 40%;
    max-height: 90%;
    left:50%;
    top: 50%;
    transform: translate(-50%, -50%);/*translate(x, y) Takes only the middle of te image*/
   }
  </style>
  <script>
   var adder = 0;
   var array_image = [];//Initializes array_image
   var orientation = [];//Puts images that are inverted
   function back()
   {
    adder--;
    if(orientation[adder]!=1) //When "exif" is defined: rotates and sets the position again
    {
     document.getElementById("img").style.transform="translate(-50%, -50%) rotate("+orientation[adder]+"deg)";
    }
    else //After, to the others ones is needed to rotate 0 degrees and sets the position again
    {
     document.getElementById("img").style.transform = "translate(-50%, -50%) rotate(0deg)";
    }
    if(adder>=0) //This is necessary to avoid "array index out of bounds"
    {
     document.getElementById("img").src = array_image[adder];
    }
    else
    {
     adder++;
    }
   }
   function next()
   {
    adder++;
    if(orientation[adder]!=0) //When "exif" is defined: rotates and sets the position again
    {
     alert(orientation[adder]);//Indicates which image is inverted
     document.getElementById("img").style.transform="translate(-50%, -50%) rotate("+orientation[adder]+"deg)";
    }
    else //After, to the others ones is needed to rotate 0 degrees and sets the position again
    {
     document.getElementById("img").style.transform = "translate(-50%, -50%) rotate(0deg)";
    }
    if(adder < array_image.length) //This is necessary to avoid "array index out of bounds"
    {
     document.getElementById("img").src = array_image[adder];
    }
    else 
    {
     adder--;
    }
   }
   function storage(source, degree)//Stores image path in array_image
   {
    orientation.push(degree);//Appends multiple values to the orientation 
    array_image.push(source);//Appends multiple values to the array_image
   }
  </script>
 </head>
 <body>
  <input type="button" value="<<<" onclick="back();"/>
  <input type="button" value=">>>" onclick="next();"/>
  <?php
   $pattern = "*.[jJ][pP][gG]";//Only ".jpg" or .JPG
   $files = glob($pattern);//Searches for all paths match the pattern
   foreach($files as $key=>$path)//Adds image addresses to the javascript array
   {
    @$exif = exif_read_data($path);

    if (!empty($exif['Orientation']))//If "exif" is set, then your image is inverted
    {
     switch($exif['Orientation'])
     {//Maybe will be necessary chage the value dregrees
      case 3: 
       echo "<script>storage('$path',180);</script>";//Populates arrays; storage(path,dregrees)
      break;
      case 6:
       echo "<script>storage('$path',90);</script>";//Populates arrays; storage(path,dregrees)
      break;
      case 8:
       echo "<script>storage('$path',270);</script>";//Populates arrays; storage(path,dregrees)
      break;
     }
    }
    else
    {
     echo "<script>storage('$path',0);</script>";//Populates arrays
    }
   }
   echo "<img id=img src='".$files[0]."'/>";//Aways prints the "first" position of the array files[]
  ?>
 </body>
</html>