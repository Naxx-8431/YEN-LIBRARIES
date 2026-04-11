<!-- ENQUIRY SIDEBAR -->
<div class="enquiry-sidebar" id="enquirySidebar">
  <div class="enquiry-tab" id="enquiryTab" tabindex="0" role="button">Enquire Now</div>
  <button type="button" onclick="document.getElementById('enquirySidebar').classList.remove('open')" aria-label="Close form" style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; font-size: 32px; font-weight: 400; line-height: 1; color: var(--clr-text-muted, #777); cursor: pointer; padding: 0; z-index: 10;">&times;</button>
  <h3 style="margin-top: 0;">Quick Enquiry</h3>
  <form id="enquiryForm" action="api/save_enquire.php" method="post">
    <input class="enquiry-field" type="text" name="name" placeholder="Your Name *" required>
    <input class="enquiry-field" type="email" name="email" placeholder="Email Address">
    <input class="enquiry-field" type="tel" name="phone" placeholder="Phone Number *" required>
    <textarea class="enquiry-field enquiry-field--textarea" name="message" placeholder="Message…" required></textarea>
    <button type="submit" class="enquiry-submit">Send Enquiry</button>
  </form>
</div>
