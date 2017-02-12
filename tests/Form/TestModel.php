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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TestModel
     */
    public function setId(int $id): TestModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSomeText(): string
    {
        return $this->someText;
    }

    /**
     * @param string $someText
     * @return TestModel
     */
    public function setSomeText(string $someText): TestModel
    {
        $this->someText = $someText;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     * @return TestModel
     */
    public function setBirthday(\DateTime $birthday): TestModel
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return TestModel
     */
    public function setActive(bool $active): TestModel
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return array
     */
    public function getFavoriteCars(): array
    {
        return $this->favoriteCars;
    }

    /**
     * @param array $favoriteCars
     * @return TestModel
     */
    public function setFavoriteCars(array $favoriteCars): TestModel
    {
        $this->favoriteCars = $favoriteCars;

        return $this;
    }



//    ButtonType
//    CollectionType
//    CountryType
//    CurrencyType
//    DateIntervalType
//    DateTimeType
//    DateType
//    EmailType
//    FileType
//    FormType
//    HiddenType
//    IntegerType
//    LanguageType
//    LocaleType
//    MoneyType
//    NumberType
//    PasswordType
//    PercentType
//    RadioType
//    RangeType
//    RepeatedType
//    ResetType
//    SearchType
//    SubmitType
//    TextareaType
//    TextType
//    TimeType
//    TimezoneType
//    UrlType

}
