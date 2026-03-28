import os
import re

directory = r"c:\Users\Fathima Afreen\OneDrive\Desktop\YEN-LIBRARY"

file_list = [
    "index.html",
    "repository.html",
    "e-resources.html",
    "services.html",
    "about.html"
]

header_fixed = """    <a href="index.html" class="header__logo" aria-label="Yenepoya Libraries Home">
      <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Central Library">
      <img src="https://library.yenepoya.edu.in/images/naac.png" alt="NAAC" class="header__logo-naac">
    </a>"""

footer_img_replacement = '<img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Libraries">'

header_pattern = re.compile(r'(<a\s+href="index\.html"\s+class="header__logo"[^>]*>)(.*?)(</a>)', re.DOTALL)
footer_pattern = re.compile(r'(<div\s+class="footer__(?:brand-logo|logo)"[^>]*>)\s*(<img[^>]*assets/images/logo\.png[^>]*>)\s*(.*?)\s*(</div>)', re.DOTALL)

for filename in file_list:
    filepath = os.path.join(directory, filename)
    if not os.path.exists(filepath):
        print(f"File not found: {filename}")
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    original = content
    
    # Replace header logo
    content = header_pattern.sub(header_fixed, content)
    
    # Replace footer logo
    # For footer, we specifically replace the child img tag
    def footer_sub(match):
        prefix = match.group(1)
        # Replacing just the image item
        middle = footer_img_replacement
        rest = match.group(3) # Text or other siblings
        suffix = match.group(4)
        return prefix + "\n            " + middle + "\n            " + rest + "\n          " + suffix

    content = footer_pattern.sub(footer_sub, content)
    
    if content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {filename}")
    else:
        print(f"No changes in {filename}")
