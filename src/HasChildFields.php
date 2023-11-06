<?php

namespace Workup\Nova\DependencyContainer;

trait HasChildFields
{
    protected $childFieldsArr = [];

    /**
     * @param  [array] $childFields [meta fields]
     *
     * @return void
     */
    protected function extractChildFields($childFields): void
    {
        foreach ($childFields as $childField) {
            if ($childField instanceof DependencyContainer) {
                $this->extractChildFields($childField->meta['fields']);
            } else {
                if (array_search($childField->attribute, array_column($this->childFieldsArr, 'attribute')) === false) {
                    // @todo: we should not randomly apply rules to child-fields.
                    $childField = $this->applyRulesForChildFields($childField);
                    $this->childFieldsArr[] = $childField;
                }
            }
        }
    }

    /**
     * @param  [array] $childField
     *
     * @return mixed [array] $childField
     */
    protected function applyRulesForChildFields($childField): mixed
    {
        if (isset($childField->rules)) {
            $childField->rules[] = "sometimes:required:" . $childField->attribute;
        }

        if (isset($childField->creationRules)) {
            $childField->creationRules[] = "sometimes:required:" . $childField->attribute;
        }

        if (isset($childField->updateRules)) {
            $childField->updateRules[] = "sometimes:required:" . $childField->attribute;
        }

        return $childField;
    }
}
