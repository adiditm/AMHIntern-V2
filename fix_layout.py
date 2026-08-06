import sys, re

file_path = 'z:/ProjectsX/AMHIntern/main/reorderout.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

start_idx = content.find('<div class="form-group" style="margin-left:-15px" id="phonemailspon">')
end_idx = content.find('<!--Kolom Kanan -->')

if start_idx == -1 or end_idx == -1:
    print("Could not find boundaries")
    sys.exit(1)

block = content[start_idx:end_idx]

trailing_html = """										</div>
				</div>
				     
        </div>
		"""

if block.endswith(trailing_html):
    block = block[:-len(trailing_html)]

# We also need to remove the `<div class="clearfix"></div>` because we are using explicit columns now.
block = block.replace('<div class="clearfix"></div>', '')

# Fields strictly based on the visual layout in the screenshot
left_fields = ['tfSernoSpon', 'tfSponsor', 'tfPhoneSpon', 'tfEmailSpon', 'tfAlamat', 'fcountry', 'fprop', 'fkec', 'fpack', 'tfBerat']
right_fields = ['tfRecName', 'tfRecAddr', 'fkota', 'fexpe', 'tfRecPhone', 'tfOngkir']

parts = block.split('<div class="col-lg-6 col-md-6 divtr"')

header = parts[0]
divs = parts[1:]

left_divs = []
right_divs = []
other_divs = []

for div in divs:
    div_html = '<div class="col-lg-12 col-md-12 divtr"' + div
    
    is_left = any(f in div_html for f in left_fields)
    is_right = any(f in div_html for f in right_fields)
    
    if is_left:
        left_divs.append(div_html)
    elif is_right:
        right_divs.append(div_html)
    else:
        other_divs.append(div_html)

new_block = header + '<div class="row">\n'
new_block += '<div class="col-md-6">\n'
new_block += ''.join(left_divs)
new_block += ''.join(other_divs) # just in case
new_block += '</div>\n'
new_block += '<div class="col-md-6">\n'
new_block += ''.join(right_divs)
new_block += '</div>\n'
new_block += '</div>\n' # End row

new_block += trailing_html

content = content[:start_idx] + new_block + content[end_idx:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Layout updated with original visual order successfully.")
