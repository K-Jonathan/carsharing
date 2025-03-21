<!--
This is the "Contact" page for Flamin-Go!, designed to provide multiple ways for users to get in touch.

📸 Hero Section:
- Features a large background image (`.startbild.Contback`) with bold headline text.
- Communicates the theme: “Help & More – How to Reach Us”.

📬 Info Banner:
- Uses `pinkboxR1` elements to display a banner with an email icon and a friendly message.
- Encourages users to connect with the team for questions or support.

📦 Main Contact Content (`.contbox1`):
Structured into three columns within `.contact-container`:

1. 💬 Instagram Outreach:
   - Text invites users to message via Instagram for help or updates.
   - Promotes following the brand to stay updated on news and sustainability efforts.
   - Includes a button linking to Flamin-Go’s Instagram profile.

2. 📱 Promo Video:
   - Displays a looping, muted video styled as a phone screen.
   - Highlights social engagement and brand story.

3. 📧 Email Contact Form:
   - Basic form with fields for name, email, and message.
   - Submit button styled to match the branding.

🧩 Footer:
- The global footer is included at the end (`includes/footer.php`).

This contact page offers users a visually engaging and multi-channel way to connect with the Flamin-Go team.
-->
<?php include("includes/header.php"); ?>
    
<!-- Contact page specific classes for landing page below Header (e.g. backgroundimage) -->
<div class="startbild Contback">
        <p class="whitebig">
            FLAMIN-GO! <br> <p class="whiteandthin"> Hilfe & Mehr <br></p>
            <p class="whitemedium" style="margin-bottom: 500px;"> Wie erreicht ihr uns?
        </p>
    </div>
    <!-- Text Banner with icon below fixated backgroundpicture -->
    <div class="pinkboxR1"></div>
    <div class="pinkboxR1">
    <p class="blackandthin container">Du hast Fragen oder möchtest mit uns in Verbindung treten?
        <img src="images/iconsmail.png" alt="mail"></p></div>
    </div>  <div class="pinkboxR1"></div>
 
 
<div style="display:flex;">
    <div class="blacksmall contbox1">

 <!-- Container including text, video and Email-form -->    
<div class="contact-container">
<div class="contover blackandthinbig"><strong>KONTAKT</strong></div><div class="contover2"></div>
<div class="text-contact">
 
        <p class="blackandthinsmall">
           Schreibe uns bei Instagram, wenn du Fragen hast oder Unterstützung benötigst.
           Folge uns, um keine <strong>NEWS und Angebote</strong> zu verpassen. Wir nehmen euch auf unserem Profil bei unseren Nachhaltigkeitsaktionen mit und zeigen in Livestreams unsere Fortschritte!
<br> <br> Wir freuen uns auf eure Nachrichten!</p>
        <!-- Button to Instagrampage of FlaminGO  -->
    <div class="button-containercont">
            <a href="https://www.instagram.com/flamin_go_green?igsh=NzB3azVra2JlcGh4&utm_source=qr" target="_blank" class="btncont">Instagram besuchen</a>
       
    </div>
    </div>
    <!-- Video in shape of a phone with pink borders -->
    <div class="contboxvid">
        <video autoplay loop muted playsinline class="bg-video">
            <source src="/Carsharing/videos/instavideo.mp4" type="video/mp4">
           
        </video></div>
    <!-- Email-form -->
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
</div> 
</div>
 
 
<?php include("includes/footer.php"); ?>