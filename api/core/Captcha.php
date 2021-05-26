<?php

namespace core;

class Captcha
{
    private const permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    public \GdImage $image;


    public function execute() {
        $this->prepareImage();
        $this->renderCaptchaString();
    }

    private function generateString()
    {
        function generate_string($input, $strength = 5)
        {
            $input_length = strlen($input);
            $random_string = '';
            for ($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }

            return $random_string;
        }
    }

    private function prepareImage()
    {
        $this->image = imagecreatetruecolor(150, 200);
        imageantialias($this->image, true);

        $colors = [];

        $red = rand(125, 175);
        $green = rand(125, 175);
        $blue = rand(125, 175);

        for ($i = 0; $i < 5; $i++) {
            $colors[] = imagecolorallocate($this->image, $red - 20 * $i, $green - 20 * $i, $blue - 20 * $i);
        }

        imagefill($this->image, 0, 0, $colors[0]);

        for ($i = 0; $i < 10; $i++) {
            imagesetthickness($this->image, rand(2, 10));
            $rect_color = $colors[rand(1, 4)];
            imagerectangle($this->image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $rect_color);
        }
    }

    private function renderCaptchaString()
    {
        $black = imagecolorallocate($this->image, 0, 0, 0);
        $white = imagecolorallocate($this->image, 255, 255, 255);
        $textcolors = [$black, $white];
        echo __FILE__;
        $fonts = [dirname(__FILE__) . '\fonts\Acme.ttf', dirname(__FILE__) . '\fonts\Ubuntu.ttf', dirname(__FILE__) . '\fonts\Merriweather.ttf', dirname(__FILE__) . '\fonts\PlayfairDisplay.ttf'];

        $string_length = 6;
        $captcha_string = generate_string(self::permitted_chars, $string_length);

        for ($i = 0; $i < $string_length; $i++) {
            $letter_space = 170 / $string_length;
            $initial = 15;

            imagettftext($this->image, 20, rand(-15, 15), $initial + $i * $letter_space, rand(20, 40), $textcolors[rand(0, 1)], $fonts[array_rand($fonts)], $captcha_string[$i]);
        }

        header('Content-type: image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }
}
