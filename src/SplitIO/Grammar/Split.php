<?php
namespace SplitIO\Grammar;

/*
{
      "orgId": "bf083ab0-b402-11e5-b7d5-024293b5d101",
      "environment": "bf9d9ce0-b402-11e5-b7d5-024293b5d101",
      "name": "myFeature",
      "trafficTypeId": "u",
      "trafficTypeName": "User",
      "seed": 93590075,
      "status": "ACTIVE",
      "killed": false,
      "conditions": [
        {
          "matcherGroup": {
            "combiner": "AND",
            "matchers": [
              {
                "matcherType": "ALL_KEYS",
                "negate": false,
                "userDefinedSegmentMatcherData": null,
                "whitelistMatcherData": null
              }
            ]
          },
          "partitions": [
            {
              "treatment": "on",
              "size": 50
            },
            {
              "treatment": "control",
              "size": 50
            }
          ]
        }
      ]
    }
*/

use SplitIO\Common\Di;

class Split
{
    private $orgId = null;

    private $environment = null;

    private $name = null;

    private $trafficTypeId = null;

    private $trafficTypeName = null;

    private $seed = null;

    private $status = null;

    private $killed = false;

    private $conditions = null;

    public function __construct(array $split)
    {
        Di::getInstance()->getLogger()->debug(print_r($split, true));

        $this->orgId = $split['orgId'];
        $this->environment = $split['environment'];
        $this->name = $split['name'];
        $this->trafficTypeId = $split['trafficTypeId'];
        $this->trafficTypeName = $split['trafficTypeName'];
        $this->seed = $split['seed'];
        $this->status = $split['status'];
        $this->killed = $split['killed'];

        Di::getInstance()->getLogger()->info("Constructing Split: ".$this->name);

        if (isset($split['conditions']) && is_array($split['conditions'])) {
            $this->conditions = array();
            foreach ($split['conditions'] as $condition) {
                $this->conditions[] = new Condition($condition);
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    public function getSeed()
    {
        return $this->seed;
    }

    public function getInvolvedUsers()
    {
        $users = [];
        foreach ($this->conditions as $condition) {
            if ($condition instanceof \SplitIO\Grammar\Condition) {
                $users = array_merge($users, $condition->getInvolvedUsers());
            }
        }

        return array_unique($users, SORT_STRING);
    }
}