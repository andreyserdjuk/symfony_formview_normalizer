<?php

namespace Tests\Form;

class TestModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $someText;

    /**
     * BirthdayType
     *
     * @var \DateTime
     */
    protected $birthday;

    /**
     * CheckboxType
     *
     * @var bool
     */
    protected $active;

    /**
     * ChoiceType
     *
     * @var array
     */
    protected $favoriteCars;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSomeText()
    {
        return $this->someText;
    }

    /**
     * @param string $someText
     */
    public function setSomeText($someText)
    {
        $this->someText = $someText;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return array
     */
    public function getFavoriteCars()
    {
        return $this->favoriteCars;
    }

    /**
     * @param array $favoriteCars
     */
    public function setFavoriteCars($favoriteCars)
    {
        $this->favoriteCars = $favoriteCars;
    }
}
