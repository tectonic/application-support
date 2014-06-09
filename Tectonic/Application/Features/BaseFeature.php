<?php namespace Application\Features;

use Application\Eventing\EventGenerator;

/**
 * Class BaseFeature
 *
 * The base feature class implements function to check to see if the feature is enabled,
 * and whether or not the user has access to that feature. Feature access should be defined
 * as part of the user interface as well as feature activity (enabled or disabled).
 *
 * @package Application\Support
 */

abstract class BaseFeature
{
    use EventGenerator;

    /**
     * If defined, sets the name for the feature in question. If not defined, the class
     * will determine the feature name based on the name of the class.
     *
     * @var
     */
    protected $feature;

    /**
     * Stores the feature repository.
     *
     * @var FeatureRepository
     */
    protected $featureRepository;

    /**
     * The human-readable version of the feature name.
     *
     * @var
     */
    protected $name;

    /**
     * The constructor simply checks the status of the required feature, and whether or not the
     * user actually has access to be able to execute the feature. If either of these fail an
     * exception will be thrown.
     */
    public function __construct()
    {
        $this->checkStatus();
        $this->checkAccess();
    }

    /**
     * The check status function checks to see whether or not the feature is enabled. If the feature
     * is not enabled, then a FeatureNotEnabledException is thrown.
     *
     * @throws FeatureNotEnabledException
     */
    public function checkStatus()
    {
        if (!$this->isEnabled()) {
            throw new FeatureNotEnabledException($this);
        }
    }

    /**
     * Every feature must have the access it requires defined. This needs to be defined within
     * an allowed() method, and should return true if access is allowed, false if not - and null
     * if no access is actually required (aka, feature is allowed for all).
     *
     * @throws AccessForbiddenException
     */
    public function checkAccess()
    {
        $allowed = $this->allowed();

        if (false === $allowed) {
            throw new AccessForbiddenException;
        }
    }

    /**
     * Checks to see whether the required feature is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        $featureRepository = App::make('Application\Features\FeatureRepository');

        $feature = $featureRepository->findByFeature($this->featureCodeName());

        return $feature->enabled;
    }

    /**
     * Returns the base name of the class used for the feature.
     *
     * @return string
     */
    protected function featureCodeName()
    {
        if (!is_null($this->feature)) {
            return $this->feature;
        }

        return class_basename($this);
    }

    /**
     * The following method must be implemented on each feature. If no access is
     * required, the function should return null.
     * @return mixed
     */
    abstract protected function allowed();
}
