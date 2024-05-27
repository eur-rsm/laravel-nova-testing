<?php

namespace EUR\RSM\LaravelNovaTesting\Browser\Concerns;

use Laravel\Dusk\Browser;

trait InteractsWithBooleanField
{
    public function assertBooleanField(Browser $browser, string $attribute, bool $value): self
    {
        $field = '#' . $attribute . '-boolean-field';

        $browser->assertAttribute($field, 'checkedvalue', $value ? 'true' : 'false');
    }

    public function toggleBooleanField(Browser $browser, string $attribute, bool $value): void
    {
        $field = '#' . $attribute . '-boolean-field';
        $browser->whenAvailable($field, function (Browser $browser) use ($field, $value) {
            $currentValue = filter_var($browser->attribute($field, 'checkedvalue'), FILTER_VALIDATE_BOOLEAN);

            if ($currentValue === $value) {
                return;
            }

            $browser->element($field)->click();
            $browser->pause(500);

            $newValue = filter_var($browser->attribute($field, 'checkedvalue'), FILTER_VALIDATE_BOOLEAN);
            if ($newValue !== $value) {
                throw new \InvalidArgumentException("Boolean field cannot be changed [{$field}].", 1716812989);
            }
        });
    }
}
