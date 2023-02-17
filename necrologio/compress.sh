#!/bin/sh
echo "Compressing images..."

magick mogrify -resize 512 -format webp *.png && rm -f *.png

echo "Done."