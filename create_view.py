import os

directory = r"c:\Users\Fathima Afreen\OneDrive\Desktop\YEN-LIBRARY\assets\images\about"
output_file = r"c:\Users\Fathima Afreen\OneDrive\Desktop\YEN-LIBRARY\view_images.html"

files = [f for f in os.listdir(directory) if f.startswith("about-central") and f.endswith(".webp")]
files.sort(key=lambda x: int(os.path.splitext(x)[0].replace("about-central", "")))

html_content = """<!DOCTYPE html>
<html>
<head>
    <title>View Images</title>
    <style>
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; padding: 20px; }
        .item { border: 1px solid #ccc; padding: 10px; text-align: center; }
        img { max-width: 100%; height: auto; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>Central Library Images</h1>
    <div class="grid">
"""

for f in files:
    html_content += f"""
        <div class="item">
            <img src="assets/images/about/{f}" alt="{f}">
            <p>{f}</p>
        </div>
    """

html_content += """
    </div>
</body>
</html>"""

with open(output_file, 'w', encoding='utf-8') as f:
    f.write(html_content)

print(f"Created {output_file}")
