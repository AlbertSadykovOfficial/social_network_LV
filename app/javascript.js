canvas = O('logo') 
context = canvas.getContext('2d') 
context.font = 'bold italic 58px Georgia' 
context.textBaseline = 'top'

image = new Image() 
image.src = 'Crocodile.ico'

image.onload = function() 
{  
	gradient = context.createLinearGradient(0, 0, 0, 89)  
	gradient.addColorStop(0.00, '#faa')  
	gradient.addColorStop(0.66, '#f00')  
	context.fillStyle = gradient  
	context.fillText( " Social Network", 0, 30)  
	context.strokeText(" Social Network", 0, 30)  
	context.drawImage(image, 530, 10, 85, 85) 
	//context.drawImage(myimage, 380, 20,  80, 220)
}

function O(i)
{
   return typeof i == 'object' ? i : document.getElementById(i) 
}
function S(i)
{
   return O(i).style
}
function C(i) 
{ 
  return document.getElementsByClassName(i)
} 
