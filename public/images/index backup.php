<?php
global $mySession;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->

<script src="<?=APPLICATION_URL?>jquery.bxslider/jquery.bxslider.js"></script>
<!-- bxSlider CSS file -->
<link href="<?=APPLICATION_URL?>jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />



<script type="text/javascript">

$(document).ready(function(){
	//alert("fdhdfh");
  $('.bxslider').bxSlider();
  
});

</script>



<div style="width:100%; height:auto;" align="center">
           
     <!--<div style="max-width:100%; height:475px; background-image:url(<?=IMAGES_URL?>backgreen.png); background-repeat:no-repeat; background-position:center">-->
    
     <div style="width:100%; background-position:center">
           
       
                <div style="width:1000px; height:475px; display:inline-block; border:#009 solid 2px;">
               <!------content1--------->
                    <div align="left" style="width:1000px; float:left">    
                         
                         <div style="margin-right:120px; float:left; margin-left:15px; margin-top:58px; width:515px;" class="fontheading">
                    
                                
                               <label>Create & Sell Custom T-Shirts with <br/>
                                 Zero Upfront Costs.<br/> </label>
                                 <div class="subtitles" style="margin-left:9px; margin-top:9px">
                                    <img src="<?=IMAGES_URL?>textarrow.png" style="margin-left:5px;" /><label style="margin-left:10px"> No Upfront Costs, no risks. Buyers pre-order their tees online on your                                       <br/>
                                     </label><label style="margin-left:30px;"> campaign page, so you don't get stuck paying the bills.</label>
                                 </div>
                                 
                                 <div class="subtitles" style="margin-left:9px; margin-top:35px">
                                  <img src="<?=IMAGES_URL?>textarrow.png" style="margin-left:5px;"/><label style="margin-left:10px"> High-quality prints. We only use retail-quality screen printing (no                               digital <br/>
                                    </label><label style="margin-left:30px">prints) so you get a t-shirt you can be proud of.</label>
                                 </div>
                             
                        </div>
                        
                        <div style=" float:right; margin-right:-1px; margin-top:-275px;">
                            
                                  <img src="<?=IMAGES_URL?>2t-shirt.png"/>
                            
                       </div>
                   
                   </div>
               <!------content1--------->
               
            
              
               <!-------content2---------->	
          
                    <div align="left" style="width:1000px;">
                    
                        <div style="float:left; margin-top:60px; width:520px" >
                                <label style="font-family:aaarghnormal; margin-left:10px; font-size:30px; color:#177e40;">
                                    Custom T-Shirt Printing <br/>
                                </label>
                        
                        
                                <label style="font-family:'Bradley Hand ITC'; font-size:24px; color:#959595;">
                                    &nbsp;&nbsp;Personalise Clothing with text, designs or photos
                                </label>
                              
                       </div>
                      
                      <?php  
					  if($mySession->TeeLoggedID=="")
					  {
					  ?>
                        <div style="float:left; margin-left:125px; margin-top:20px;">
                                 <img src="<?=IMAGES_URL?>getstartedbtn.png" />
                        </div>
                        <?php
					  }
						?>
           
                  </div>            
               <!-------content2---------->
              </div>
           
     </div>
     
     <div style="max-width:100%; background-image:url(<?=IMAGES_URL?>backgrnd2.png); background-repeat:repeat-x;"> 
           
            <!-------content3---------->	
               <div align="center" style="width:1000px; height:261px;">
            	
                    <div style="float:left; width:245px; height:198px; margin-left:98px; margin-top:28px;">
                            
                            <div style="margin-left:-20px; margin-bottom:2px">
                                <label style="font-family:Arial; font-size:24px; color:#0dcd5a">
                                    <b> 1. Select your Product</b>
                                </label>
                            </div>
                            
                            <div>
                                <img src="<?=IMAGES_URL?>tshirt1st.png" />
                            </div>	
                          
                   </div>
                   
                   <div style="float:left; width:75px; margin-top:24px; margin-left:-10px">
                        <img src="<?=IMAGES_URL?>broadarrow.png" />
                   </div>
                   
                   <div style="float:left; width:247px; margin-top:29px; height:198px;">
                    
                        <div>
                            <label style="font-family:Arial; font-size:24px; color:#0dcd5a">
                                <b> 2. Create your Design</b>
                             </label>
                        </div>
                        
                        <div>
                            <img src="<?=IMAGES_URL?>image2.png" height="202"/>
                        </div>
                        
                   </div>
                   
                   <div style="float:left; width:75px; margin-top:23px; margin-left:-10px">
                        <img src="<?=IMAGES_URL?>broadarrow.png" />
                   </div>
                   
                   <div style="float:left; width:245px; height:198px; margin-top:28px;">
                    
                        <div>
                           <label style="font-family:Arial; font-size:24px; color:#0dcd5a">
                                <b> 3. We do our Magic</b>
                             </label>
                        </div>
                        
                        <div>
                            <img src="<?=IMAGES_URL?>image3.png" />
                        </div>
                   </div>
                    
              
            </div> 
            <!-------content3---------->
      </div>  
      
          
            
      <div style="max-width:100%; background-image:url(<?=IMAGES_URL?>backgrnd3.png); background-repeat:repeat-x;">
            <!-------content4---------->	
              
               <div align="center" style="width:1000px; height:383px;">
            	
                	 <div style="margin-bottom:2px;" align="left">
                        	<label style="font-family:aaarghnormal; font-size:30px; color:#177e40;">
                            	Check out our featured campaigns
                            </label>
                     </div>
                   
                    <div>
                    	
                        <div class="bxslider" style="padding:0px; margin:0px;width:500px;">
                        
                        	
                            <div style="width:200px; height:350px;">
                            	
                                <div style="width:305px; float:left; height:240px; margin-left:65px; margin-top:15px;">
                                	
                                	<img src="<?=IMAGES_URL?>slidertee.png" />
                                    
                                </div>
                                
                                <div style="width:150px; height:60px; float:left; margin-top:258px; margin-left:-280px;">
                                	<img src="<?=IMAGES_URL?>sliderimgname.png" />
                                </div>
                            	
                                <div align="left" style="width:485px; height:230px; float:left; margin-left:10px; margin-top:15px;">
                                  	
                                    <div style="width:470px; height:45px;">
                                    	<img src="<?=IMAGES_URL?>teeheading.png" />
                                    </div>
                                    
                                    <div style="float:left; width:480px; height:160px; margin-top:10px; margin-left:8px;">
                                    	<label style="font-family:'Arial Black'; font-size:14px; color:#606060">
                                        	 Dummy text is here.Dummy text is here.Dummy text is here.
                                            Dummy text is here.Dummy text is here.Dummy text is here.
                                            Dummy text is here.Dummy text is here.Dummy text is here.
                                            Dummy text is here.Dummy text is here.Dummy text is here.Dummy text is here.
                                           
                                        </label>
                                    </div>
                                    	
                                 </div>
                                 
                                 <div align="left" style="width:275px; height:80px; float:left; background-image:url(<?=IMAGES_URL?>teebarborder.png); background-repeat:no-repeat; margin-left:20px;">
                                 	<div style="width:200px; height:20px; margin-top:8px; margin-left:10px;">
                                    	<label style="font-family:'Arial'; font-size:17px; color:#606060">
                                        	<b>$20.00</b>
                                        </label>
                                        <label style="font-family:'Arial'; font-size:14px; color:#606060; font-weight:normal;">
                                        	63 of 50 reserved
                                        </label>
                                    </div>
                                    
                                    <div style="width:255px; margin-top:4px; margin-left:10px;">
                                    	<img src="<?=IMAGES_URL?>greenbar.png" />
                                    </div>
                                    
                                    <div style="margin-top:5px; margin-left:13px;">
                                    	<div style="width:13px; height:14px; float:left;">
                                    	   <img src="<?=IMAGES_URL?>timerclock.png" />
                                        </div>
                                    	<label style="font-family:'Arial'; font-size:10px; color:#606060; font-weight:normal;">
                                        	&nbsp;2 days and 20 hours left
                                        </label>
                                    </div>
                                    <!--<img src="images/teebar.png" />-->
                                    
                                 </div>
                                 
                                 <div style="float:left; width:245px; height:50px; margin-top:42px; margin-left:20px">
                                 	 <img src="<?=IMAGES_URL?>viewcampaignbtn.png" />
                                 </div>
                            </div>
                            
                           
                            <!-- <img src="images/sliderimage.png" width="300" height="320" />
                            
                             <img src="images/2t-shirt.png"  width="300" height="320" />-->
                            
                        </div>
                    	
                    </div>
                    
            </div>	
            <!-------content4---------->	
      </div>
      
      
       <div style="max-width:100%; background-image:url(<?=IMAGES_URL?>backgrnd4.png); background-repeat:repeat-x;">
      	    <!-------content5---------->	
                <div align="center" style="width:1000px; height:297px;">
            		
                <div style="margin-bottom:2px; width:540px; float:left" align="left"> 
                   <div>
                        	<label style="font-family:aaarghnormal;  font-size:20px; color:#177e40;">
                            	Find Inspiration
                            </label>
                            <label style="font-family:aaarghnormal; font-size:14px; color:#606060;">
                            	Exciting campaign on teespring
                            </label>
                             
                     </div>
                    
                   <div style="width:540px; height:250px; background-color:#FFF;position:absolute">
                   		<div style="margin-top:8px; margin-left:8px;">
                           <img src="<?=IMAGES_URL?>loopimg.png" />
                        </div>
                   </div>
                         <!-- <div style="width:540px; height:250px; background-color:#FFF;position:absolute">
                            <div style="width:540px; height:auto;margin-top:10px;margin-left:10px;"> 
                            <?php
                            $k=0;
                            for($i=0; $i<32; $i++)
                            {
                                
                            ?>
                                    <img src="images/featuredimg.png" width="64" height="58" style="padding:0px; margin:0px; margin-top:-3px; margin-left:-2px; border:#FFFFFF thin 1px;" />
                               <?php
                                $k++;
                                if($k%8==0)
                                {
                                    ?>
                                    <br/>
                                    <?php
                                }
                                
                            }
                            ?>
                           </div>       
                          </div>-->
                     
                            
                  </div>
                   
                   
                  <div style="float:left; margin-left:17px;"> 
                       <div align="left"> 
                     	
                        	<label style="font-family:aaarghnormal; margin-left:10px; font-size:20px; color:#177e40;">
                            	Testimonials
                            </label>
                            <label style="font-family:aaarghnormal; font-size:14px; color:#606060;">
                            	What people are saying
                            </label>
                            
                       </div>
                       
                       <div style="width:430px; height:240px; margin-top:3px; margin-left:3px; background-image:url(<?=IMAGES_URL?>testimBG.png); background-repeat:no-repeat;">
                       		<div align="left" style="margin-top:12px; float:left; margin-left:12px;">
                               <img src="<?=IMAGES_URL?>testimoaudio.png" />
                            </div>
                            
                            <div  style="margin-top:15px; float:left; margin-left:20px;">
                            	<label style="font-family:'Palatino Linotype'; font-size:18px; color:#177e40;">
                                	- Name
                                </label>
                                <label style="font-family:'Palatino Linotype'; margin-left:10px; font-size:18px; color:#606060;">
                                	- Site Name
                                </label>
                            </div>
                            
                            <div style="float:left; margin-top:20px; margin-left:20px;">
                            	<div style="float:left; height:62px; width:62px;">
                                	<img src="<?=IMAGES_URL?>testimoprofileimg.png" />
                                </div>
                                
                                <div style="float:left; text-align:left; margin-left:10px; width:290px; height:150px;">
                                	<label style="font:'Arial'; font-weight:normal; font-size:14px; color:#606060;">
                                    " this contains some text. this contains some text.this contains some text.this contains some text.
                                    this contains some text. this contains some text. this contains some text.
                                    this contains some text. this contains some text."
                                    </label>
                                </div>
                            </div>
                           <!-- <img src="images/testimonial.png" />-->
                            
                       </div>
                     
                   </div>               
           
            </div>
            <!-------content5---------->	
       </div>
      
</div>

           
     

