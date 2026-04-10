import os
import glob
import re

files_to_update = ['index.php', 'about.php', 'contact.php', 'e-resources.php', 'events.php', 'repository.php', 'research.php', 'services.php']

for file in files_to_update:
    path = os.path.join('e:/PHP/htdocs/YEN-LIBRARY', file)
    if not os.path.exists(path):
        continue
        
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # 1. For index.php, remove the hardcoded part entirely.
    if file == 'index.php':
        # Remove anything between the Notification Sidebar comment and the AI chat box comment
        content = re.sub(r'<!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->[\s\S]*?(?=<!-- ═══════════════ AI CHAT BOX ════════════════ -->)', '', content)
    
    # 2. Check if the component was already included
    if 'components/notifications.php' not in content:
        # 3. Inject it right before <!-- Scripts --> or <!-- AI CHAT BOX --> or </body>
        injection = "\n  <!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->\n  <?php include 'components/notifications.php'; ?>\n"
        
        if '<!-- ═══════════════ AI CHAT BOX ════════════════ -->' in content:
            content = content.replace('<!-- ═══════════════ AI CHAT BOX ════════════════ -->', injection + '\n  <!-- ═══════════════ AI CHAT BOX ════════════════ -->')
        elif '<!-- Scripts -->' in content:
            content = content.replace('<!-- Scripts -->', injection + '\n  <!-- Scripts -->')
        elif '<script>' in content:
            content = content.replace('<script>', injection + '\n  <script>')
        else:
            content = content.replace('</body>', injection + '\n</body>')
            
    if content != original_content:
        with open(path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f'Updated {file}')
