<?php

namespace OnzaMe\Images\Tests;

class ExampleTest extends BaseTest
{

    /** @test */
    public function true_is_true()
    {
        $this->assertIsArray(config('onzame_images.limits.canvas_sizes'));
        $this->assertIsArray(get_request_rules_for('photos'));
        $this->assertIsString(get_request_rules_for_as_string('photos'));
    }
}
