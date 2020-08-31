# onza-me/images package

## Optimization images by Kraken.io
Optimization images're going through external service [kraken.io](https://kraken.io)

## Env variables

    # kraken.io variables
    ONZA_ME_KRAKENIO_API_KEY={API KEY}
    ONZA_ME_KRAKENIO_API_SECRET={API SECRET}
    
    # Limits of image dimensions and file sizes for getting validation rules
    ONZA_ME_IMAGES_CANVAS_SIZE_LIMITS={image_type|default:default}:{max width}*{max height},{min width}*{min height};photos:5000*5000,1920*1920
    ONZA_ME_IMAGES_PREVIEW_CANVAS_SIZE_LIMITS=default:{preview_name}|{1 preview width}*{1 preview height},{preview_name}|{2 preview width}*{2 preview height};photos:default|480*290,first|360*180,second|180*60
    # File size in kilobytes, default: 10000
    ONZA_ME_IMAGES_MAX_FILE_SIZE=10000
