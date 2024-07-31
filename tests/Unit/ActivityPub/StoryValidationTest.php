<?php

namespace Tests\Unit\ActivityPub;

use App\Util\ActivityPub\Validator\StoryValidator;
use PHPUnit\Framework\TestCase;

class StoryValidationTest extends TestCase
{
    public $activity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activity = json_decode('{"@context":"https://www.w3.org/ns/activitystreams","id":"https://pixelfed.test/stories/dansup/338581222496276480","type":"Story","to":["https://pixelfed.test/users/dansup/followers"],"cc":[],"attributedTo":"https://pixelfed.test/users/dansup","published":"2021-09-01T07:20:53+00:00","expiresAt":"2021-09-02T07:21:04+00:00","duration":3,"can_reply":true,"can_react":true,"attachment":{"type":"Image","url":"https://pixelfed.test/storage/_esm.t3/xV9/R2LF1xwhAA/011oqKVPDySG3WCPW7yIs2wobvccoITMnG/yT_FZX04f2DCzTA3K8HD2OS7FptXTHPiE1c_ZkHASBQ8UlPKH4.jpg","mediaType":"image/jpeg"}}', true);
    }

    /** @test */
    public function schemaTest(): void
    {
        $this->assertTrue(StoryValidator::validate($this->activity));
    }

    /** @test */
    public function invalidContext(): void
    {
        $activity = $this->activity;
        unset($activity['@context']);
        $activity['@@context'] = 'https://www.w3.org/ns/activitystreams';
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function missingContext(): void
    {
        $activity = $this->activity;
        unset($activity['@context']);
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function missingId(): void
    {
        $activity = $this->activity;
        unset($activity['id']);
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function missingType(): void
    {
        $activity = $this->activity;
        unset($activity['type']);
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function invalidType(): void
    {
        $activity = $this->activity;
        $activity['type'] = 'Store';
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function missingTo(): void
    {
        $activity = $this->activity;
        unset($activity['to']);
        $this->assertFalse(StoryValidator::validate($activity));
    }

    /** @test */
    public function missingTimestamps(): void
    {
        $activity = $this->activity;
        unset($activity['published']);
        $this->assertFalse(StoryValidator::validate($activity));

        $activity = $this->activity;
        unset($activity['expiresAt']);
        $this->assertFalse(StoryValidator::validate($activity));
    }
}
