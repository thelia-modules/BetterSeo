<?php

namespace BetterSeo\Model\Base;

use \Exception;
use \PDO;
use BetterSeo\Model\BetterSeo as ChildBetterSeo;
use BetterSeo\Model\BetterSeoI18nQuery as ChildBetterSeoI18nQuery;
use BetterSeo\Model\BetterSeoQuery as ChildBetterSeoQuery;
use BetterSeo\Model\Map\BetterSeoI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class BetterSeoI18n implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BetterSeo\\Model\\Map\\BetterSeoI18nTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the locale field.
     * Note: this column has a database default value of: 'en_US'
     * @var        string
     */
    protected $locale;

    /**
     * The value for the noindex field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $noindex;

    /**
     * The value for the nofollow field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $nofollow;

    /**
     * The value for the canonical_field field.
     * @var        string
     */
    protected $canonical_field;

    /**
     * The value for the h1 field.
     * @var        string
     */
    protected $h1;

    /**
     * The value for the mesh_text_1 field.
     * @var        string
     */
    protected $mesh_text_1;

    /**
     * The value for the mesh_url_1 field.
     * @var        string
     */
    protected $mesh_url_1;

    /**
     * The value for the mesh_text_2 field.
     * @var        string
     */
    protected $mesh_text_2;

    /**
     * The value for the mesh_url_2 field.
     * @var        string
     */
    protected $mesh_url_2;

    /**
     * The value for the mesh_text_3 field.
     * @var        string
     */
    protected $mesh_text_3;

    /**
     * The value for the mesh_url_3 field.
     * @var        string
     */
    protected $mesh_url_3;

    /**
     * The value for the mesh_text_4 field.
     * @var        string
     */
    protected $mesh_text_4;

    /**
     * The value for the mesh_url_4 field.
     * @var        string
     */
    protected $mesh_url_4;

    /**
     * The value for the mesh_text_5 field.
     * @var        string
     */
    protected $mesh_text_5;

    /**
     * The value for the mesh_url_5 field.
     * @var        string
     */
    protected $mesh_url_5;

    /**
     * The value for the mesh_1 field.
     * @var        string
     */
    protected $mesh_1;

    /**
     * The value for the mesh_2 field.
     * @var        string
     */
    protected $mesh_2;

    /**
     * The value for the mesh_3 field.
     * @var        string
     */
    protected $mesh_3;

    /**
     * The value for the mesh_4 field.
     * @var        string
     */
    protected $mesh_4;

    /**
     * The value for the mesh_5 field.
     * @var        string
     */
    protected $mesh_5;

    /**
     * The value for the json_data field.
     * @var        string
     */
    protected $json_data;

    /**
     * @var        BetterSeo
     */
    protected $aBetterSeo;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->locale = 'en_US';
        $this->noindex = 0;
        $this->nofollow = 0;
    }

    /**
     * Initializes internal state of BetterSeo\Model\Base\BetterSeoI18n object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>BetterSeoI18n</code> instance.  If
     * <code>obj</code> is an instance of <code>BetterSeoI18n</code>, delegates to
     * <code>equals(BetterSeoI18n)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return BetterSeoI18n The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return BetterSeoI18n The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [locale] column value.
     *
     * @return   string
     */
    public function getLocale()
    {

        return $this->locale;
    }

    /**
     * Get the [noindex] column value.
     *
     * @return   int
     */
    public function getNoindex()
    {

        return $this->noindex;
    }

    /**
     * Get the [nofollow] column value.
     *
     * @return   int
     */
    public function getNofollow()
    {

        return $this->nofollow;
    }

    /**
     * Get the [canonical_field] column value.
     *
     * @return   string
     */
    public function getCanonicalField()
    {

        return $this->canonical_field;
    }

    /**
     * Get the [h1] column value.
     *
     * @return   string
     */
    public function getH1()
    {

        return $this->h1;
    }

    /**
     * Get the [mesh_text_1] column value.
     *
     * @return   string
     */
    public function getMeshText1()
    {

        return $this->mesh_text_1;
    }

    /**
     * Get the [mesh_url_1] column value.
     *
     * @return   string
     */
    public function getMeshUrl1()
    {

        return $this->mesh_url_1;
    }

    /**
     * Get the [mesh_text_2] column value.
     *
     * @return   string
     */
    public function getMeshText2()
    {

        return $this->mesh_text_2;
    }

    /**
     * Get the [mesh_url_2] column value.
     *
     * @return   string
     */
    public function getMeshUrl2()
    {

        return $this->mesh_url_2;
    }

    /**
     * Get the [mesh_text_3] column value.
     *
     * @return   string
     */
    public function getMeshText3()
    {

        return $this->mesh_text_3;
    }

    /**
     * Get the [mesh_url_3] column value.
     *
     * @return   string
     */
    public function getMeshUrl3()
    {

        return $this->mesh_url_3;
    }

    /**
     * Get the [mesh_text_4] column value.
     *
     * @return   string
     */
    public function getMeshText4()
    {

        return $this->mesh_text_4;
    }

    /**
     * Get the [mesh_url_4] column value.
     *
     * @return   string
     */
    public function getMeshUrl4()
    {

        return $this->mesh_url_4;
    }

    /**
     * Get the [mesh_text_5] column value.
     *
     * @return   string
     */
    public function getMeshText5()
    {

        return $this->mesh_text_5;
    }

    /**
     * Get the [mesh_url_5] column value.
     *
     * @return   string
     */
    public function getMeshUrl5()
    {

        return $this->mesh_url_5;
    }

    /**
     * Get the [mesh_1] column value.
     *
     * @return   string
     */
    public function getMesh1()
    {

        return $this->mesh_1;
    }

    /**
     * Get the [mesh_2] column value.
     *
     * @return   string
     */
    public function getMesh2()
    {

        return $this->mesh_2;
    }

    /**
     * Get the [mesh_3] column value.
     *
     * @return   string
     */
    public function getMesh3()
    {

        return $this->mesh_3;
    }

    /**
     * Get the [mesh_4] column value.
     *
     * @return   string
     */
    public function getMesh4()
    {

        return $this->mesh_4;
    }

    /**
     * Get the [mesh_5] column value.
     *
     * @return   string
     */
    public function getMesh5()
    {

        return $this->mesh_5;
    }

    /**
     * Get the [json_data] column value.
     *
     * @return   string
     */
    public function getJsonData()
    {

        return $this->json_data;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::ID] = true;
        }

        if ($this->aBetterSeo !== null && $this->aBetterSeo->getId() !== $v) {
            $this->aBetterSeo = null;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [locale] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::LOCALE] = true;
        }


        return $this;
    } // setLocale()

    /**
     * Set the value of [noindex] column.
     *
     * @param      int $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setNoindex($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->noindex !== $v) {
            $this->noindex = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::NOINDEX] = true;
        }


        return $this;
    } // setNoindex()

    /**
     * Set the value of [nofollow] column.
     *
     * @param      int $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setNofollow($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nofollow !== $v) {
            $this->nofollow = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::NOFOLLOW] = true;
        }


        return $this;
    } // setNofollow()

    /**
     * Set the value of [canonical_field] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setCanonicalField($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->canonical_field !== $v) {
            $this->canonical_field = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::CANONICAL_FIELD] = true;
        }


        return $this;
    } // setCanonicalField()

    /**
     * Set the value of [h1] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setH1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->h1 !== $v) {
            $this->h1 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::H1] = true;
        }


        return $this;
    } // setH1()

    /**
     * Set the value of [mesh_text_1] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshText1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_text_1 !== $v) {
            $this->mesh_text_1 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_TEXT_1] = true;
        }


        return $this;
    } // setMeshText1()

    /**
     * Set the value of [mesh_url_1] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshUrl1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_url_1 !== $v) {
            $this->mesh_url_1 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_URL_1] = true;
        }


        return $this;
    } // setMeshUrl1()

    /**
     * Set the value of [mesh_text_2] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshText2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_text_2 !== $v) {
            $this->mesh_text_2 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_TEXT_2] = true;
        }


        return $this;
    } // setMeshText2()

    /**
     * Set the value of [mesh_url_2] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshUrl2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_url_2 !== $v) {
            $this->mesh_url_2 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_URL_2] = true;
        }


        return $this;
    } // setMeshUrl2()

    /**
     * Set the value of [mesh_text_3] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshText3($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_text_3 !== $v) {
            $this->mesh_text_3 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_TEXT_3] = true;
        }


        return $this;
    } // setMeshText3()

    /**
     * Set the value of [mesh_url_3] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshUrl3($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_url_3 !== $v) {
            $this->mesh_url_3 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_URL_3] = true;
        }


        return $this;
    } // setMeshUrl3()

    /**
     * Set the value of [mesh_text_4] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshText4($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_text_4 !== $v) {
            $this->mesh_text_4 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_TEXT_4] = true;
        }


        return $this;
    } // setMeshText4()

    /**
     * Set the value of [mesh_url_4] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshUrl4($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_url_4 !== $v) {
            $this->mesh_url_4 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_URL_4] = true;
        }


        return $this;
    } // setMeshUrl4()

    /**
     * Set the value of [mesh_text_5] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshText5($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_text_5 !== $v) {
            $this->mesh_text_5 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_TEXT_5] = true;
        }


        return $this;
    } // setMeshText5()

    /**
     * Set the value of [mesh_url_5] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMeshUrl5($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_url_5 !== $v) {
            $this->mesh_url_5 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_URL_5] = true;
        }


        return $this;
    } // setMeshUrl5()

    /**
     * Set the value of [mesh_1] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMesh1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_1 !== $v) {
            $this->mesh_1 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_1] = true;
        }


        return $this;
    } // setMesh1()

    /**
     * Set the value of [mesh_2] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMesh2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_2 !== $v) {
            $this->mesh_2 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_2] = true;
        }


        return $this;
    } // setMesh2()

    /**
     * Set the value of [mesh_3] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMesh3($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_3 !== $v) {
            $this->mesh_3 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_3] = true;
        }


        return $this;
    } // setMesh3()

    /**
     * Set the value of [mesh_4] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMesh4($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_4 !== $v) {
            $this->mesh_4 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_4] = true;
        }


        return $this;
    } // setMesh4()

    /**
     * Set the value of [mesh_5] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setMesh5($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mesh_5 !== $v) {
            $this->mesh_5 = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::MESH_5] = true;
        }


        return $this;
    } // setMesh5()

    /**
     * Set the value of [json_data] column.
     *
     * @param      string $v new value
     * @return   \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     */
    public function setJsonData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->json_data !== $v) {
            $this->json_data = $v;
            $this->modifiedColumns[BetterSeoI18nTableMap::JSON_DATA] = true;
        }


        return $this;
    } // setJsonData()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->locale !== 'en_US') {
                return false;
            }

            if ($this->noindex !== 0) {
                return false;
            }

            if ($this->nofollow !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BetterSeoI18nTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BetterSeoI18nTableMap::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BetterSeoI18nTableMap::translateFieldName('Noindex', TableMap::TYPE_PHPNAME, $indexType)];
            $this->noindex = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BetterSeoI18nTableMap::translateFieldName('Nofollow', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nofollow = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BetterSeoI18nTableMap::translateFieldName('CanonicalField', TableMap::TYPE_PHPNAME, $indexType)];
            $this->canonical_field = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BetterSeoI18nTableMap::translateFieldName('H1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->h1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshText1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_text_1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshUrl1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_url_1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshText2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_text_2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshUrl2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_url_2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshText3', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_text_3 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshUrl3', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_url_3 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshText4', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_text_4 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshUrl4', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_url_4 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshText5', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_text_5 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : BetterSeoI18nTableMap::translateFieldName('MeshUrl5', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_url_5 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : BetterSeoI18nTableMap::translateFieldName('Mesh1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : BetterSeoI18nTableMap::translateFieldName('Mesh2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : BetterSeoI18nTableMap::translateFieldName('Mesh3', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_3 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : BetterSeoI18nTableMap::translateFieldName('Mesh4', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_4 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : BetterSeoI18nTableMap::translateFieldName('Mesh5', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mesh_5 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : BetterSeoI18nTableMap::translateFieldName('JsonData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->json_data = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 22; // 22 = BetterSeoI18nTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \BetterSeo\Model\BetterSeoI18n object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aBetterSeo !== null && $this->id !== $this->aBetterSeo->getId()) {
            $this->aBetterSeo = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBetterSeoI18nQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBetterSeo = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see BetterSeoI18n::setDeleted()
     * @see BetterSeoI18n::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildBetterSeoI18nQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BetterSeoI18nTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aBetterSeo !== null) {
                if ($this->aBetterSeo->isModified() || $this->aBetterSeo->isNew()) {
                    $affectedRows += $this->aBetterSeo->save($con);
                }
                $this->setBetterSeo($this->aBetterSeo);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BetterSeoI18nTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::LOCALE)) {
            $modifiedColumns[':p' . $index++]  = 'LOCALE';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::NOINDEX)) {
            $modifiedColumns[':p' . $index++]  = 'NOINDEX';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::NOFOLLOW)) {
            $modifiedColumns[':p' . $index++]  = 'NOFOLLOW';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::CANONICAL_FIELD)) {
            $modifiedColumns[':p' . $index++]  = 'CANONICAL_FIELD';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::H1)) {
            $modifiedColumns[':p' . $index++]  = 'H1';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_1)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_TEXT_1';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_1)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_URL_1';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_2)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_TEXT_2';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_2)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_URL_2';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_3)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_TEXT_3';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_3)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_URL_3';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_4)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_TEXT_4';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_4)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_URL_4';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_5)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_TEXT_5';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_5)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_URL_5';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_1)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_1';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_2)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_2';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_3)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_3';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_4)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_4';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_5)) {
            $modifiedColumns[':p' . $index++]  = 'MESH_5';
        }
        if ($this->isColumnModified(BetterSeoI18nTableMap::JSON_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'JSON_DATA';
        }

        $sql = sprintf(
            'INSERT INTO better_seo_i18n (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'LOCALE':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case 'NOINDEX':
                        $stmt->bindValue($identifier, $this->noindex, PDO::PARAM_INT);
                        break;
                    case 'NOFOLLOW':
                        $stmt->bindValue($identifier, $this->nofollow, PDO::PARAM_INT);
                        break;
                    case 'CANONICAL_FIELD':
                        $stmt->bindValue($identifier, $this->canonical_field, PDO::PARAM_STR);
                        break;
                    case 'H1':
                        $stmt->bindValue($identifier, $this->h1, PDO::PARAM_STR);
                        break;
                    case 'MESH_TEXT_1':
                        $stmt->bindValue($identifier, $this->mesh_text_1, PDO::PARAM_STR);
                        break;
                    case 'MESH_URL_1':
                        $stmt->bindValue($identifier, $this->mesh_url_1, PDO::PARAM_STR);
                        break;
                    case 'MESH_TEXT_2':
                        $stmt->bindValue($identifier, $this->mesh_text_2, PDO::PARAM_STR);
                        break;
                    case 'MESH_URL_2':
                        $stmt->bindValue($identifier, $this->mesh_url_2, PDO::PARAM_STR);
                        break;
                    case 'MESH_TEXT_3':
                        $stmt->bindValue($identifier, $this->mesh_text_3, PDO::PARAM_STR);
                        break;
                    case 'MESH_URL_3':
                        $stmt->bindValue($identifier, $this->mesh_url_3, PDO::PARAM_STR);
                        break;
                    case 'MESH_TEXT_4':
                        $stmt->bindValue($identifier, $this->mesh_text_4, PDO::PARAM_STR);
                        break;
                    case 'MESH_URL_4':
                        $stmt->bindValue($identifier, $this->mesh_url_4, PDO::PARAM_STR);
                        break;
                    case 'MESH_TEXT_5':
                        $stmt->bindValue($identifier, $this->mesh_text_5, PDO::PARAM_STR);
                        break;
                    case 'MESH_URL_5':
                        $stmt->bindValue($identifier, $this->mesh_url_5, PDO::PARAM_STR);
                        break;
                    case 'MESH_1':
                        $stmt->bindValue($identifier, $this->mesh_1, PDO::PARAM_STR);
                        break;
                    case 'MESH_2':
                        $stmt->bindValue($identifier, $this->mesh_2, PDO::PARAM_STR);
                        break;
                    case 'MESH_3':
                        $stmt->bindValue($identifier, $this->mesh_3, PDO::PARAM_STR);
                        break;
                    case 'MESH_4':
                        $stmt->bindValue($identifier, $this->mesh_4, PDO::PARAM_STR);
                        break;
                    case 'MESH_5':
                        $stmt->bindValue($identifier, $this->mesh_5, PDO::PARAM_STR);
                        break;
                    case 'JSON_DATA':
                        $stmt->bindValue($identifier, $this->json_data, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BetterSeoI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getLocale();
                break;
            case 2:
                return $this->getNoindex();
                break;
            case 3:
                return $this->getNofollow();
                break;
            case 4:
                return $this->getCanonicalField();
                break;
            case 5:
                return $this->getH1();
                break;
            case 6:
                return $this->getMeshText1();
                break;
            case 7:
                return $this->getMeshUrl1();
                break;
            case 8:
                return $this->getMeshText2();
                break;
            case 9:
                return $this->getMeshUrl2();
                break;
            case 10:
                return $this->getMeshText3();
                break;
            case 11:
                return $this->getMeshUrl3();
                break;
            case 12:
                return $this->getMeshText4();
                break;
            case 13:
                return $this->getMeshUrl4();
                break;
            case 14:
                return $this->getMeshText5();
                break;
            case 15:
                return $this->getMeshUrl5();
                break;
            case 16:
                return $this->getMesh1();
                break;
            case 17:
                return $this->getMesh2();
                break;
            case 18:
                return $this->getMesh3();
                break;
            case 19:
                return $this->getMesh4();
                break;
            case 20:
                return $this->getMesh5();
                break;
            case 21:
                return $this->getJsonData();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['BetterSeoI18n'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['BetterSeoI18n'][serialize($this->getPrimaryKey())] = true;
        $keys = BetterSeoI18nTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLocale(),
            $keys[2] => $this->getNoindex(),
            $keys[3] => $this->getNofollow(),
            $keys[4] => $this->getCanonicalField(),
            $keys[5] => $this->getH1(),
            $keys[6] => $this->getMeshText1(),
            $keys[7] => $this->getMeshUrl1(),
            $keys[8] => $this->getMeshText2(),
            $keys[9] => $this->getMeshUrl2(),
            $keys[10] => $this->getMeshText3(),
            $keys[11] => $this->getMeshUrl3(),
            $keys[12] => $this->getMeshText4(),
            $keys[13] => $this->getMeshUrl4(),
            $keys[14] => $this->getMeshText5(),
            $keys[15] => $this->getMeshUrl5(),
            $keys[16] => $this->getMesh1(),
            $keys[17] => $this->getMesh2(),
            $keys[18] => $this->getMesh3(),
            $keys[19] => $this->getMesh4(),
            $keys[20] => $this->getMesh5(),
            $keys[21] => $this->getJsonData(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBetterSeo) {
                $result['BetterSeo'] = $this->aBetterSeo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BetterSeoI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLocale($value);
                break;
            case 2:
                $this->setNoindex($value);
                break;
            case 3:
                $this->setNofollow($value);
                break;
            case 4:
                $this->setCanonicalField($value);
                break;
            case 5:
                $this->setH1($value);
                break;
            case 6:
                $this->setMeshText1($value);
                break;
            case 7:
                $this->setMeshUrl1($value);
                break;
            case 8:
                $this->setMeshText2($value);
                break;
            case 9:
                $this->setMeshUrl2($value);
                break;
            case 10:
                $this->setMeshText3($value);
                break;
            case 11:
                $this->setMeshUrl3($value);
                break;
            case 12:
                $this->setMeshText4($value);
                break;
            case 13:
                $this->setMeshUrl4($value);
                break;
            case 14:
                $this->setMeshText5($value);
                break;
            case 15:
                $this->setMeshUrl5($value);
                break;
            case 16:
                $this->setMesh1($value);
                break;
            case 17:
                $this->setMesh2($value);
                break;
            case 18:
                $this->setMesh3($value);
                break;
            case 19:
                $this->setMesh4($value);
                break;
            case 20:
                $this->setMesh5($value);
                break;
            case 21:
                $this->setJsonData($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = BetterSeoI18nTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setLocale($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setNoindex($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setNofollow($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCanonicalField($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setH1($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setMeshText1($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setMeshUrl1($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setMeshText2($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setMeshUrl2($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setMeshText3($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setMeshUrl3($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setMeshText4($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setMeshUrl4($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setMeshText5($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setMeshUrl5($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setMesh1($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setMesh2($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setMesh3($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setMesh4($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setMesh5($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setJsonData($arr[$keys[21]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BetterSeoI18nTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BetterSeoI18nTableMap::ID)) $criteria->add(BetterSeoI18nTableMap::ID, $this->id);
        if ($this->isColumnModified(BetterSeoI18nTableMap::LOCALE)) $criteria->add(BetterSeoI18nTableMap::LOCALE, $this->locale);
        if ($this->isColumnModified(BetterSeoI18nTableMap::NOINDEX)) $criteria->add(BetterSeoI18nTableMap::NOINDEX, $this->noindex);
        if ($this->isColumnModified(BetterSeoI18nTableMap::NOFOLLOW)) $criteria->add(BetterSeoI18nTableMap::NOFOLLOW, $this->nofollow);
        if ($this->isColumnModified(BetterSeoI18nTableMap::CANONICAL_FIELD)) $criteria->add(BetterSeoI18nTableMap::CANONICAL_FIELD, $this->canonical_field);
        if ($this->isColumnModified(BetterSeoI18nTableMap::H1)) $criteria->add(BetterSeoI18nTableMap::H1, $this->h1);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_1)) $criteria->add(BetterSeoI18nTableMap::MESH_TEXT_1, $this->mesh_text_1);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_1)) $criteria->add(BetterSeoI18nTableMap::MESH_URL_1, $this->mesh_url_1);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_2)) $criteria->add(BetterSeoI18nTableMap::MESH_TEXT_2, $this->mesh_text_2);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_2)) $criteria->add(BetterSeoI18nTableMap::MESH_URL_2, $this->mesh_url_2);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_3)) $criteria->add(BetterSeoI18nTableMap::MESH_TEXT_3, $this->mesh_text_3);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_3)) $criteria->add(BetterSeoI18nTableMap::MESH_URL_3, $this->mesh_url_3);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_4)) $criteria->add(BetterSeoI18nTableMap::MESH_TEXT_4, $this->mesh_text_4);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_4)) $criteria->add(BetterSeoI18nTableMap::MESH_URL_4, $this->mesh_url_4);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_TEXT_5)) $criteria->add(BetterSeoI18nTableMap::MESH_TEXT_5, $this->mesh_text_5);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_URL_5)) $criteria->add(BetterSeoI18nTableMap::MESH_URL_5, $this->mesh_url_5);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_1)) $criteria->add(BetterSeoI18nTableMap::MESH_1, $this->mesh_1);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_2)) $criteria->add(BetterSeoI18nTableMap::MESH_2, $this->mesh_2);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_3)) $criteria->add(BetterSeoI18nTableMap::MESH_3, $this->mesh_3);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_4)) $criteria->add(BetterSeoI18nTableMap::MESH_4, $this->mesh_4);
        if ($this->isColumnModified(BetterSeoI18nTableMap::MESH_5)) $criteria->add(BetterSeoI18nTableMap::MESH_5, $this->mesh_5);
        if ($this->isColumnModified(BetterSeoI18nTableMap::JSON_DATA)) $criteria->add(BetterSeoI18nTableMap::JSON_DATA, $this->json_data);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(BetterSeoI18nTableMap::DATABASE_NAME);
        $criteria->add(BetterSeoI18nTableMap::ID, $this->id);
        $criteria->add(BetterSeoI18nTableMap::LOCALE, $this->locale);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getLocale();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setLocale($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getLocale());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BetterSeo\Model\BetterSeoI18n (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setNoindex($this->getNoindex());
        $copyObj->setNofollow($this->getNofollow());
        $copyObj->setCanonicalField($this->getCanonicalField());
        $copyObj->setH1($this->getH1());
        $copyObj->setMeshText1($this->getMeshText1());
        $copyObj->setMeshUrl1($this->getMeshUrl1());
        $copyObj->setMeshText2($this->getMeshText2());
        $copyObj->setMeshUrl2($this->getMeshUrl2());
        $copyObj->setMeshText3($this->getMeshText3());
        $copyObj->setMeshUrl3($this->getMeshUrl3());
        $copyObj->setMeshText4($this->getMeshText4());
        $copyObj->setMeshUrl4($this->getMeshUrl4());
        $copyObj->setMeshText5($this->getMeshText5());
        $copyObj->setMeshUrl5($this->getMeshUrl5());
        $copyObj->setMesh1($this->getMesh1());
        $copyObj->setMesh2($this->getMesh2());
        $copyObj->setMesh3($this->getMesh3());
        $copyObj->setMesh4($this->getMesh4());
        $copyObj->setMesh5($this->getMesh5());
        $copyObj->setJsonData($this->getJsonData());
        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \BetterSeo\Model\BetterSeoI18n Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildBetterSeo object.
     *
     * @param                  ChildBetterSeo $v
     * @return                 \BetterSeo\Model\BetterSeoI18n The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBetterSeo(ChildBetterSeo $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aBetterSeo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBetterSeo object, it will not be re-added.
        if ($v !== null) {
            $v->addBetterSeoI18n($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBetterSeo object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildBetterSeo The associated ChildBetterSeo object.
     * @throws PropelException
     */
    public function getBetterSeo(ConnectionInterface $con = null)
    {
        if ($this->aBetterSeo === null && ($this->id !== null)) {
            $this->aBetterSeo = ChildBetterSeoQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBetterSeo->addBetterSeoI18ns($this);
             */
        }

        return $this->aBetterSeo;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->locale = null;
        $this->noindex = null;
        $this->nofollow = null;
        $this->canonical_field = null;
        $this->h1 = null;
        $this->mesh_text_1 = null;
        $this->mesh_url_1 = null;
        $this->mesh_text_2 = null;
        $this->mesh_url_2 = null;
        $this->mesh_text_3 = null;
        $this->mesh_url_3 = null;
        $this->mesh_text_4 = null;
        $this->mesh_url_4 = null;
        $this->mesh_text_5 = null;
        $this->mesh_url_5 = null;
        $this->mesh_1 = null;
        $this->mesh_2 = null;
        $this->mesh_3 = null;
        $this->mesh_4 = null;
        $this->mesh_5 = null;
        $this->json_data = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aBetterSeo = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BetterSeoI18nTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
