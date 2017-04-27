<?php

namespace go1\util\es;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-types.html
 */
class Schema
{
    const INDEX = ES_INDEX;
    const TEMP  = -32;

    const T_BOOL    = 'boolean';
    const T_SHORT   = 'short';
    const T_INT     = 'integer';
    const T_FLOAT   = 'float';
    const T_DOUBLE  = 'double'; # Use double if you want to use aggregation feature.
    const T_TEXT    = 'text';
    const T_KEYWORD = 'keyword';
    const T_DATE    = 'date';
    const T_ARRAY   = 'array';
    const T_OBJECT  = 'object';
    const T_NESTED  = 'nested';

    const O_EDGE                = 'edge';
    const O_PORTAL              = 'portal';
    const O_CONFIG              = 'configuration';
    const O_USER                = 'user';
    const O_ACCOUNT             = 'account';
    const O_LO                  = 'lo';
    const O_PLAN                = 'plan';
    const O_ENROLMENT           = 'enrolment';
    const O_MANUAL_RECORD       = 'manual_record';
    const O_SUBMISSION          = 'asm_submission';
    const O_SUBMISSION_REVISION = 'asm_submission_revision';
    const O_GROUP               = 'group';
    const O_MAIL                = 'mail';
    const O_PAYMENT_TRANSACTION = 'payment_transaction';
    const O_QUIZ_USER_ANSWER    = 'quiz_user_answer';
    const O_ECK_METADATA        = 'eck_metadata';

    const SCHEMA = [
        'index' => self::INDEX,
        'body'  => self::BODY,
    ];

    const BODY = [
        'mappings' => self::MAPPING,
    ];

    const MAPPING = [
        self::O_EDGE                => self::EDGE_MAPPING,
        self::O_PORTAL              => self::PORTAL_MAPPING,
        self::O_CONFIG              => self::CONFIGURATION_MAPPING,
        self::O_USER                => self::USER_MAPPING,
        self::O_ACCOUNT             => self::ACCOUNT_MAPPING,
        self::O_LO                  => self::LO_MAPPING,
        self::O_PLAN                => self::PLAN_MAPPING,
        self::O_ENROLMENT           => self::ENROLMENT_MAPPING,
        self::O_MANUAL_RECORD       => self::MANUAL_RECORD_MAPPING,
        self::O_SUBMISSION          => self::SUBMISSION_MAPPING,
        self::O_SUBMISSION_REVISION => self::SUBMISSION_REVISION_MAPPING,
        self::O_GROUP               => self::GROUP_MAPPING,
        self::O_MAIL                => self::MAIL_MAPPING,
        self::O_PAYMENT_TRANSACTION => self::PAYMENT_TRANSACTION_MAPPING,
        self::O_QUIZ_USER_ANSWER    => self::QUIZ_USER_ANSWER_MAPPING,
        self::O_ECK_METADATA        => self::ECK_METADATA_MAPPING,
    ];

    const ANALYZED = [
        'fields' => [
            'analyzed' => [
                'type' => self::T_TEXT,
            ],
        ],
    ];

    const EDGE_MAPPING = [
        'properties' => [
            'id'        => ['type' => self::T_INT],
            'type_id'   => ['type' => self::T_INT],
            'source_id' => ['type' => self::T_INT],
            'target_id' => ['type' => self::T_INT],
            'weight'    => ['type' => self::T_INT],
            'data'      => ['type' => self::T_OBJECT],
        ],
    ];

    const PORTAL_MAPPING = [
        '_parent'    => ['type' => self::O_USER],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'            => ['type' => self::T_INT],
            'title'         => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'status'        => ['type' => self::T_SHORT],
            'version'       => ['type' => self::T_KEYWORD],
            'created'       => ['type' => self::T_DATE],
            'configuration' => ['type' => self::T_OBJECT],
        ],
    ];

    const CONFIGURATION_MAPPING = [
        '_parent'    => ['type' => self::O_PORTAL],
        '_routing'   => ['required' => true],
        'properties' => [
            'instance'  => ['type' => self::T_KEYWORD],
            'namespace' => ['type' => self::T_KEYWORD],
            'name'      => ['type' => self::T_KEYWORD],
            'public'    => ['type' => self::T_BOOL],
            'data'      => ['type' => self::T_OBJECT],
        ],
    ];

    const USER_MAPPING = [
        'properties' => [
            'id'           => ['type' => self::T_INT],
            'profile_id'   => ['type' => self::T_INT],
            'mail'         => ['type' => self::T_KEYWORD],
            'name'         => ['type' => self::T_KEYWORD],
            'first_name'   => ['type' => self::T_KEYWORD],
            'last_name'    => ['type' => self::T_KEYWORD],
            'created'      => ['type' => self::T_DATE],
            'login'        => ['type' => self::T_DATE],
            'access'       => ['type' => self::T_DATE],
            'status'       => ['type' => self::T_SHORT],
            'allow_public' => ['type' => self::T_BOOL],
            'avatar'       => ['type' => self::T_TEXT],
            'roles'        => ['type' => self::T_KEYWORD],
        ],
    ];

    const ACCOUNT_MAPPING = [
        '_parent'    => ['type' => self::O_USER],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'           => ['type' => self::T_INT],
            'instance'     => ['type' => self::T_KEYWORD],
            'mail'         => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'name'         => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'first_name'   => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'last_name'    => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'created'      => ['type' => self::T_DATE],
            'access'       => ['type' => self::T_DATE],
            'status'       => ['type' => self::T_SHORT],
            'allow_public' => ['type' => self::T_BOOL],
            'roles'        => ['type' => self::T_KEYWORD],
            'fields'       => ['type' => self::T_OBJECT],
            'groups'       => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'managers'     => ['type' => self::T_INT],
        ],
    ];

    const LO_MAPPING = [
        '_parent'    => ['type' => self::O_PORTAL],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'          => ['type' => self::T_INT],
            'type'        => ['type' => self::T_KEYWORD],
            'origin_id'   => ['type' => self::T_INT],
            'remote_id'   => ['type' => self::T_KEYWORD],
            'status'      => ['type' => self::T_SHORT],
            'private'     => ['type' => self::T_BOOL],
            'published'   => ['type' => self::T_INT],
            'marketplace' => ['type' => self::T_BOOL],
            'sharing'     => ['type' => self::T_SHORT],
            'instance_id' => ['type' => self::T_INT],
            'language'    => ['type' => self::T_KEYWORD],
            'locale'      => ['type' => self::T_KEYWORD],
            'title'       => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'description' => ['type' => self::T_TEXT],
            'tags'        => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'image'       => ['type' => self::T_TEXT],
            'pricing'     => [
                'type'       => self::T_NESTED,
                'properties' => [
                    'currency'     => ['type' => self::T_KEYWORD],
                    'price'        => ['type' => self::T_DOUBLE],
                    'tax'          => ['type' => self::T_DOUBLE],
                    'tax_included' => ['type' => self::T_BOOL],
                ],
            ],
            'duration'    => ['type' => self::T_INT], # Duration in minute
            'assessors'   => ['type' => self::T_INT],
            'created'     => ['type' => self::T_DATE],
            'updated'     => ['type' => self::T_DATE],
            'fields'      => ['type' => self::T_OBJECT],
            'authors'     => [
                'type'       => self::T_NESTED,
                'properties' => self::USER_MAPPING['properties'],
            ],
        ],
    ];

    const PLAN_MAPPING = [
        'properties' => [
            'id'          => ['type' => self::T_INT],
            'user_id'     => ['type' => self::T_INT],
            'assigner_id' => ['type' => self::T_INT],
            'entity_type' => ['type' => self::T_KEYWORD],
            'entity_id'   => ['type' => self::T_INT],
            'status'      => ['type' => self::T_SHORT],
            'created'     => ['type' => self::T_DATE],
            'due'         => ['type' => self::T_DATE],
            'data'        => ['type' => self::T_OBJECT],
        ],
    ];

    /**
     * @TODO Make sure the revisions are indexed on content re-indexing.
     */
    const ENROLMENT_MAPPING = [
        '_routing'   => ['required' => true],
        'properties' => [
            'id'         => ['type' => self::T_INT],
            'profile_id' => ['type' => self::T_INT],
            'lo_id'      => ['type' => self::T_INT],
            'account_id' => ['type' => self::T_INT],
            'parent_id'  => ['type' => self::T_INT],
            'status'     => ['type' => self::T_SHORT],
            'result'     => ['type' => self::T_INT],
            'pass'       => ['type' => self::T_INT],
            'assessors'  => ['type' => self::T_INT],
            'start_date' => ['type' => self::T_DATE],
            'end_date'   => ['type' => self::T_DATE],
            'changed'    => ['type' => self::T_DATE],
            // Duration between end date and start date (hours).
            // @todo Support quiz and interactive.
            'duration'   => ['type' => self::T_INT],
            'lo'         => [
                'properties' => self::LO_MAPPING['properties'],
            ],
            'account'    => [
                'properties' => self::ACCOUNT_MAPPING['properties'],
            ],
            'metadata'   => [
                'properties' => [
                    'course_enrolment_id' => ['type' => self::T_INT],
                    'course_id'           => ['type' => self::T_INT],
                    'status'              => ['type' => self::T_SHORT],
                    'has_assessor'        => ['type' => self::T_SHORT],
                ],
            ],
        ],
    ];

    const MANUAL_RECORD_MAPPING = [
        'properties' => [
            'id'          => ['type' => self::T_INT],
            'entity_type' => ['type' => self::T_KEYWORD],
            'entity_id'   => ['type' => self::T_INT],
            'user_id'     => ['type' => self::T_INT],
            'verified'    => ['type' => self::T_BOOL],
            'created'     => ['type' => self::T_DATE],
            'updated'     => ['type' => self::T_DATE],
            'data'        => ['type' => self::T_OBJECT],
        ],
    ];

    const SUBMISSION_MAPPING = [
        '_parent'    => ['type' => self::O_ENROLMENT],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'          => ['type' => self::T_INT],
            'revision_id' => ['type' => self::T_INT],
            'profile_id'  => ['type' => self::T_INT],
            'status'      => ['type' => self::T_SHORT],
            'created'     => ['type' => self::T_DATE],
            'updated'     => ['type' => self::T_DATE],
            'published'   => ['type' => self::T_INT],
            'assessors'   => ['type' => self::T_INT],
        ],
    ];

    const SUBMISSION_REVISION_MAPPING = [
        '_parent'    => ['type' => self::O_SUBMISSION],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'      => ['type' => self::T_INT],
            'status'  => ['type' => self::T_SHORT],
            'created' => ['type' => self::T_DATE],
            'updated' => ['type' => self::T_DATE],
            'data'    => [
                'properties' => [
                    'files' => ['type' => self::T_OBJECT],
                ],
            ],
        ],
    ];

    const GROUP_MAPPING = [
        '_parent'    => ['type' => self::O_PORTAL],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'         => ['type' => self::T_INT],
            'title'      => ['type' => self::T_KEYWORD],
            'user_id'    => ['type' => self::T_INT],
            'visibility' => ['type' => self::T_SHORT],
            'created'    => ['type' => self::T_DATE],
            'updated'    => ['type' => self::T_DATE],
        ],
    ];

    const MAIL_MAPPING = [
        '_parent'    => ['type' => self::O_PORTAL],
        '_routing'   => ['required' => true],
        'properties' => [
            'id'          => ['type' => self::T_INT],
            'recipient'   => ['type' => self::T_KEYWORD],
            'sender'      => ['type' => self::T_KEYWORD],
            'cc'          => ['type' => self::T_KEYWORD],
            'bcc'         => ['type' => self::T_KEYWORD],
            'subject'     => ['type' => self::T_KEYWORD],
            'body'        => ['type' => self::T_TEXT],
            'html'        => ['type' => self::T_TEXT],
            'context'     => ['type' => self::T_OBJECT],
            'options'     => ['type' => self::T_OBJECT],
            'attachments' => ['type' => self::T_OBJECT],
            'timestamp'   => ['type' => self::T_DATE],
        ],
    ];

    const PAYMENT_TRANSACTION_MAPPING = [
        'properties' => [
            'id'             => ['type' => self::T_INT],
            'instance_id'    => ['type' => self::T_INT],
            'local_id'       => ['type' => self::T_INT],
            'email'          => ['type' => self::T_KEYWORD],
            'status'         => ['type' => self::T_SHORT],
            'amount'         => ['type' => self::T_DOUBLE],
            'currency'       => ['type' => self::T_KEYWORD],
            'created'        => ['type' => self::T_DATE],
            'updated'        => ['type' => self::T_DATE],
            'payment_method' => ['type' => self::T_KEYWORD],
            'user_id'        => ['type' => self::T_INT],
            'user'           => [
                'properties' => self::USER_MAPPING['properties'],
            ],
            'items'          => [
                'type'       => self::T_NESTED,
                'properties' => self::PAYMENT_TRANSACTION_ITEM_MAPPING['properties'],
            ],
        ],
    ];

    const PAYMENT_TRANSACTION_ITEM_MAPPING = [
        'properties' => [
            'id'           => ['type' => self::T_INT],
            'product_type' => ['type' => self::T_KEYWORD],
            'product_id'   => ['type' => self::T_INT],
            'qty'          => ['type' => self::T_INT],
            'price'        => ['type' => self::T_DOUBLE],
            'tax'          => ['type' => self::T_DOUBLE],
            'tax_included' => ['type' => self::T_BOOL],
        ],
    ];

    const QUIZ_USER_ANSWER_MAPPING = [
        'properties' => [
            'id'            => ['type' => self::T_INT],
            'question_type' => ['type' => self::T_KEYWORD],
            'answer'        => ['type' => self::T_TEXT],
            'created'       => ['type' => self::T_DATE],
            'updated'       => ['type' => self::T_DATE],
            'is_correct'    => ['type' => self::T_BOOL],
            'is_skipped'    => ['type' => self::T_BOOL],
            'is_evaluated'  => ['type' => self::T_BOOL],
            'points'        => ['type' => self::T_INT],
            // @todo Handle updating question.
            'question'      => ['type' => self::T_KEYWORD] + self::ANALYZED,
            'li_id'         => ['type' => self::T_INT],
            'counter'       => ['type' => self::T_INT],
            'user_id'       => ['type' => self::T_INT],
            'user'          => [
                'properties' => self::USER_MAPPING['properties'],
            ],
        ],
    ];

    const ECK_METADATA_MAPPING = [
        '_routing'   => ['required' => true],
        'properties' => [
            'instance'      => ['type' => self::T_KEYWORD],
            'entity_type'   => ['type' => self::T_KEYWORD],
            'field'         => [
                'type' => self::T_NESTED,
                'properties' => [
                    'id'            => ['type' => self::T_INT],
                    'name'          => ['type' => self::T_KEYWORD],
                    'description'   => ['type' => self::T_TEXT],
                    'label'         => ['type' => self::T_KEYWORD],
                    'help'          => ['type' => self::T_KEYWORD],
                    'type'          => ['type' => self::T_KEYWORD],
                    'published'     => ['type' => self::T_INT],
                    'weight'        => ['type' => self::T_INT],
                    'max_rows'      => ['type' => self::T_INT],
                    'parent_field'  => ['type' => self::T_KEYWORD],
                    'data'          => ['type' => self::T_OBJECT],
                ]
            ]
        ]
    ];
}
