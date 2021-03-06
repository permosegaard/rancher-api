<?php

namespace Mauchede\RancherApi\Resource;

use JMS\Serializer\Annotation\Type;
use Mauchede\RancherApi\Exception\InvalidActionException;

/**
 * Container represents a Rancher resource typed as "container".
 *
 * @author Morgan Auchede <morgan.auchede@gmail.com>
 */
class Container extends AbstractResource
{
    /**
     * @var string[]
     *
     * @Type("array<string>")
     */
    private $command;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $description;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $imageUuid;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $name;

    /**
     * @var bool
     *
     * @Type("boolean")
     */
    private $stdinOpen = true;

    /**
     * @var bool
     *
     * @Type("boolean")
     */
    private $tty = true;
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $environment = array();

    /**
     * @var array
     * 
     * @Type("array")
     */
    private $ports = array();
    
    /**
     * @var string
     * 
     * @Type("string")
     */
    private $networkMode;
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $capAdd = array();
    
    /**
     * @var string
     * 
     * @Type("string")
     */
    private $primaryIpAddress;
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $labels = array();
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $devices = array();
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $dataVolumes = array();
    
    /**
     * @var integer
     *
     * @Type("integer")
     */
    private $memory;
    
    /**
     * @var intger
     *
     * @Type("integer")
     */
    private $memorySwap;
    
    /**
     * @var bool
     *
     * @Type("boolean")
     */
    private $privileged;
    
    /**
     * @var array
     * 
     * @Type("array")
     */
    private $restartPolicy = array();
    
    /**
     * @var string
     * 
     * @Type("string")
     */
    private $volumeDriver;
    
    /**
     * Gets the commands
     *
     * @return array
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Gets the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Gets the UUID image.
     *
     * @return string
     */
    public function getImageUuid()
    {
        return $this->imageUuid;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'container';
    }

    /**
     * @return array
     */
    public function getEnvironmentVariables()
    {
        return $this->environment;
    }

    /**
     * @return array
     */
    public function getPorts()
    {
        return $this->ports;
    }
    
    /**
     * @return string
     */
    public function getNetworkMode()
    {
        return $this->networkMode;
    }
    
    /**
     * @return array
     */
    public function getCapabilitiesAdd()
    {
        return $this->capAdd;
    }
    
     /**
     * @return string
     */
    public function getPrimaryIpAddress()
    {
        return $this->primaryIpAddress;
    }
    
    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }
    
    /**
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }
    
    /**
     * @return array
     */
    public function getDataVolumes()
    {
        return $this->dataVolumes;
    }
    
    /**
     * Gets the Memory.
     *
     * @return string
     */
    public function getMemory()
    {
        return $this->memory;
    }
    
    /**
     * Gets the Swap Memory.
     *
     * @return string
     */
    public function getMemorySwap()
    {
        return $this->memorySwap;
    }
    
    /**
     * @return array
     */
    public function getRestartPolicy()
    {
        return $this->restartPolicy;
    }
    
    /**
     * @return string
     */
    public function getVolumeDriver()
    {
        return $this->volumeDriver;
    }

    /**
     * Determines if the container is purgeable.
     *
     * @return bool
     */
    public function isPurgeable()
    {
        return isset($this->actions['purge']);
    }

    /**
     * Determines if the container is restartable.
     *
     * @return bool
     */
    public function isRestartable()
    {
        return isset($this->actions['restart']);
    }

    /**
     * Determines if the container is startable.
     *
     * @return bool
     */
    public function isStartable()
    {
        return isset($this->actions['start']);
    }

    /**
     * Determines if the console is in interactive mode.
     *
     * @return boolean
     */
    public function isStdinOpen()
    {
        return $this->stdinOpen;
    }

    /**
     * Determines if the container is stoppable.
     *
     * @return bool
     */
    public function isStoppable()
    {
        return isset($this->actions['stop']);
    }

    /**
     * Determines if the console is in TTY mode.
     *
     * @return boolean
     */
    public function isTty()
    {
        return $this->tty;
    }
    
    /**
     * Determines if is privileged.
     *
     * @return boolean
     */
    public function isPrivileged()
    {
        return $this->privileged;
    }

    /**
     * Purges the container.
     *
     * @throws InvalidActionException if the container can not be purged.
     */
    public function purge()
    {
        if (!isset($this->actions['purge'])) {
            throw new InvalidActionException(sprintf('Impossible to purge the container "%s" (current state "%s").', $this->id, $this->state));
        }

        $this->client->post($this->actions['purge']);
    }

    /**
     * Restarts the container.
     *
     * @throws InvalidActionException if the container can not be restarted.
     */
    public function restart()
    {
        if (!isset($this->actions['restart'])) {
            throw new InvalidActionException(sprintf('Impossible to restart the container "%s" (current state "%s").', $this->id, $this->state));
        }

        $this->client->post($this->actions['restart']);
    }

    /**
     * Sets the command.
     *
     * @param string[] $command
     *
     * @return $this
     */
    public function setCommand(array $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Sets the description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets the UUID image.
     *
     * @param string $imageUuid
     *
     * @return $this
     */
    public function setImageUuid($imageUuid)
    {
        if ('docker:' !== substr($imageUuid, 0, 7)) {
            $imageUuid = 'docker:' . $imageUuid;
        }

        $this->imageUuid = $imageUuid;

        return $this;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Sets the Network Mode.
     *
     * @param string $mode
     *
     * @return $this
     */
    public function setNetworkMode($mode)
    {
        $this->networkMode = $mode;

        return $this;
    }
    
    /**
     * Sets the Primary IP Address.
     *
     * @param string $ip
     *
     * @return $this
     */
    public function setPrimaryIpAddress($ip)
    {
        $this->primaryIpAddress = $ip;

        return $this;
    }
    
    /**
     * Sets the Memory.
     *
     * @param integer $bytes
     *
     * @return $this
     */
    public function setMemory($bytes)
    {
        $this->memory = $bytes;

        return $this;
    }
    
    /**
     * Sets the Swap Memory.
     *
     * @param integer $bytes
     *
     * @return $this
     */
    public function setMemorySwap($bytes)
    {
        $this->memorySwap = $bytes;

        return $this;
    }
    
    /**
     * Sets the Privileged status.
     *
     * @param bool $privileged
     *
     * @return $this
     */
    public function setPrivileged($privileged)
    {
        $this->privileged = $privileged;

        return privileged;
    }
    
    /**
     * Add Restart Policy
     * 
     * @param string $value
     * 
     * @return $this
     */
    public function setRestartPolicy($value)
    {
        $this->restartPolicy[ "name" ] = $value;
    }
    
    /**
     * Sets the Volume Driver.
     *
     * @param string $driver
     *
     * @return $this
     */
    public function setVolumeDriver($driver)
    {
        $this->volumeDriver = $driver;

        return $this;
    }

    /**
     * Add Environment Variable
     * 
     * @param string $key
     * @param string $value
     * 
     * @return $this
     */
    public function addEnvironmentVariable($key, $value)
    {
        $this->environment[ $key ] = $value;
    }
    
    /**
     * Add Port Mapping
     * 
     * @param string $protocol
     * @param int $source
     * @param int $destination
     */
    public function addPort($protocol, $source, $destination)
    {
        array_push( $this->ports, sprintf( "%d:%d/%s", $source, $destination, $protocol ) );
    }
    
    /**
     * Add Capability
     * 
     * @param string $capability
     */
    public function addCapability( $capability )
    {
        array_push( $this->capAdd, $capability );
    }
    
    /**
     * Add Label
     * 
     * @param string $key
     * @param string $value
     * 
     * @return $this
     */
    public function addLabel($key, $value)
    {
        $this->labels[ $key ] = $value;
    }
    
    /**
     * Add Device
     * 
     * @param string $device
     * 
     * @return $this
     */
    public function addDevice($device)
    {
        array_push( $this->devices, $device );
    }
    
    /**
     * Add Data Volume
     * 
     * @param string $volume
     * 
     * @return $this
     */
    public function addDataVolume($volume)
    {
        array_push( $this->dataVolumes, $volume );
    }

    /**
     * Starts a container.
     *
     * @throws InvalidActionException if the container can not be started.
     */
    public function start()
    {
        if (!isset($this->actions['start'])) {
            throw new InvalidActionException(sprintf('Impossible to start the container "%s" (current state "%s").', $this->id, $this->state));
        }

        $this->client->post($this->actions['start']);
    }

    /**
     * Stops a container.
     *
     * @param bool $remove  Determines if the container must be removed after the action.
     * @param int  $timeout Determines the time to wait before the shutdown.
     *
     * @throws InvalidActionException if the container can not be stopped.
     */
    public function stop($remove = false, $timeout = 0)
    {
        if (!isset($this->actions['stop'])) {
            throw new InvalidActionException(sprintf('Impossible to stop the container "%s" (current state "%s").', $this->id, $this->state));
        }

        $this->client->post($this->actions['stop'], array(
            'remove' => $remove,
            'timeout' => $timeout
        ));
    }
}
