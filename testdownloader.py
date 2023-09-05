import os
import requests

# Replace 'image_url' with the actual URL of the image you want to download
image_url = 'https://static.wikia.nocookie.net/tiny-rogues/images/5/5b/Twin_Chakrams.png/revision/latest?cb=20220927091707'

# Get the image data from the URL
response = requests.get(image_url)

# Check if the request was successful
if response.status_code == 200:
    # Get the image content
    image_content = response.content

    # Save the image as a PNG file
    with open('icons/image.png', 'wb') as f:
        f.write(image_content)
    print('Image downloaded and saved as image.png.')
else:
    print('Failed to download image.')
