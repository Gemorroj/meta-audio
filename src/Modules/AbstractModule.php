<?php

namespace duncan3dc\MetaAudio\Modules;

use duncan3dc\MetaAudio\File;

/**
 * Base class for modules to extend.
 */
abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var array|null $tags The parsed tags from the file.
     */
    private $tags;

    /**
     * @var bool $saveChanges Whether changes have been made that need to be saved.
     */
    private $saveChanges;

    /**
     * @var File $file The file to read.
     */
    protected $file;


    /**
     * Load the passed file.
     *
     * @param File $file The file to read
     *
     * @return $this
     */
    public function open(File $file)
    {
        # If this file is already loaded then don't do anything
        if ($this->file) {
            $path1 = $this->file->getFullPath();
            $path2 = $file->getFullPath();
            if ($path1 === $path2) {
                return $this;
            }
        }

        $this->file = $file;
        $this->tags = null;
        $this->saveChanges = false;

        return $this;
    }


    /**
     * Get all the tags from the currently loaded file.
     *
     * @return array
     */
    abstract protected function getTags();


    /**
     * Get a tag from the file.
     *
     * @param string $key The name of the tag to get
     *
     * @return mixed
     */
    protected function getTag($key)
    {
        if (!is_array($this->tags)) {
            $this->tags = $this->getTags();
        }

        if (!isset($this->tags[$key])) {
            return "";
        }

        return $this->tags[$key];
    }


    /**
     * Set a tag in the file.
     *
     * @param string $key The name of the tag to set
     * @param mixed $value The value to set the tag to
     *
     * @return $this
     */
    protected function setTag($key, $value)
    {
        $old = $this->getTag($key);

        if ($old !== $value) {
            $this->tags[$key] = $value;
            $this->saveChanges = true;
        }

        return $this;
    }


    /**
     * Write the specified tags to the currently loaded file.
     *
     * @param array The tags to write as key/value pairs
     *
     * @return void
     */
    abstract protected function putTags(array $tags);


    /**
     * Save the changes currently pending.
     *
     * @return $this
     */
    public function save()
    {
        if ($this->saveChanges) {
            $this->putTags($this->tags);
            $this->saveChanges = false;
        }
        return $this;
    }


    /**
     * Throw away any pending changes.
     *
     * @return $this
     */
    public function revert()
    {
        $this->tags = null;
        $this->saveChanges = false;
        return $this;
    }


    /**
     * Ensure changes are saved automatically when the object is destroyed.
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->saveChanges) {
            $this->save();
        }
        return $this;
    }
}
