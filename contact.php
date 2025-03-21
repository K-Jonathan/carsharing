<?php
/**
 * Contact Page – Help & Communication
 * 
 * - Provides users with multiple ways to get in touch with FLAMIN-GO!
 * - Features:
 *   - Hero section introducing the help theme.
 *   - Instagram call-to-action with description and embedded video.
 *   - Styled contact form for users to send inquiries via email.
 * - Layout combines visual appeal (background images, videos) with functional elements.
 * - Includes header and footer for consistent site design.
 * 
 * Designed to promote user interaction and support communication with the company.
 */
?>
<?php include("includes/header.php"); ?>
    <div class="startbild Contback">
        <p class="whitebig">
            FLAMIN-GO! <br> <p class="whiteandthin"> Hilfe & Mehr <br></p>
            <p class="whitemedium" style="margin-bottom: 500px;"> Wie erreicht ihr uns?
        </p>
    </div>
    <div class="pinkboxR1"></div>
    <div class="pinkboxR1">
    <p class="blackandthin container">Du hast Fragen oder möchtest mit uns in Verbindung treten?
        <img src="images/iconsmail.png" alt="mail"></p></div>
    </div>  <div class="pinkboxR1"></div>
 
 
<div style="display:flex;">
    <div class="blacksmall contbox1">
     
<div class="contact-container">
<div class="contover blackandthinbig"><strong>KONTAKT</strong></div><div class="contover2"></div>
<div class="text-contact">
 
        <p class="blackandthinsmall">
           Schreibe uns bei Instagram, wenn du Fragen hast oder Unterstützung benötigst.
           Folge uns, um keine <strong>NEWS und Angebote</strong> zu verpassen. Wir nehmen euch auf unserem Profil bei unseren Nachhaltigkeitsaktionen mit und zeigen in Livestreams unsere Fortschritte!
<br> <br> Wir freuen uns auf eure Nachrichten!</p>
        <div class="button-containercont">
            <a href="https://www.instagram.com/flamin_go_green?igsh=NzB3azVra2JlcGh4&utm_source=qr" target="_blank" class="btncont">Instagram besuchen</a>
       
    </div>
    </div>
    <div class="contboxvid">
        <video autoplay loop muted playsinline class="bg-video">
            <source src="/Carsharing/videos/instavideo.mp4" type="video/mp4">
           
        </video></div>
 
    <div class="Contacta">
        <h2 class="Contactb">Email Kontaktformular</h2>
        <form class="Contactc">
            <input type="text" class="Contactd" name="name" placeholder="Dein Name" required>
            <input type="email" class="Contactd" name="email" placeholder="Deine E-Mail" required>
            <textarea class="Contacte" name="message" rows="4" placeholder="Deine Nachricht" required></textarea>
            <button type="submit" class="Contactf">Senden</button>
        </form>
    </div>
   
       
</div>
    </div> </div>
 
 
<?php include("includes/footer.php"); ?>