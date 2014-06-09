<?php namespace Application\Features;

interface FeatureInterface
{
    /**
     * Must return the name of the feature in a human-readable format.
     *
     * @return string
     */
    public function getName();

    /**
     * The following method must be implemented on each feature. If no access is
     * required, the function should return null.
     *
     * @return mixed False on failure, true on success, null if not applicable.
     */
    public function allowed();
} 