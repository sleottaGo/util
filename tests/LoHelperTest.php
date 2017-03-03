<?php

namespace go1\util\tests;

use go1\util\EdgeTypes;
use go1\util\LoHelper;
use go1\util\schema\mock\InstanceMockTrait;
use go1\util\schema\mock\LoMockTrait;
use go1\util\schema\mock\UserMockTrait;

class LoHelperTest extends UtilTestCase
{
    use UserMockTrait;
    use LoMockTrait;
    use InstanceMockTrait;

    public function testAssessor()
    {
        $courseId = $this->createCourse($this->db, ['instance_id' => $this->createInstance($this->db, [])]);
        $assessor1Id = $this->createUser($this->db, ['mail' => 'assessor1@mail.com']);
        $assessor2Id = $this->createUser($this->db, ['mail' => 'assessor2@mail.com']);
        $this->createUser($this->db, ['mail' => 'assessor3@mail.com']);

        $this->link($this->db, EdgeTypes::COURSE_ASSESSOR, $courseId, $assessor1Id);
        $this->link($this->db, EdgeTypes::COURSE_ASSESSOR, $courseId, $assessor2Id);

        $assessors = LoHelper::assessorIds($this->db, $courseId);
        $this->assertEquals(2, count($assessors));
        $this->assertEquals($assessor1Id, $assessors[0]);
        $this->assertEquals($assessor2Id, $assessors[1]);
    }
}
