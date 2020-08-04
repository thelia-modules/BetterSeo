<?php

namespace BetterSeo\Model\Map;

use BetterSeo\Model\BetterSeoI18n;
use BetterSeo\Model\BetterSeoI18nQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'better_seo_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BetterSeoI18nTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'BetterSeo.Model.Map.BetterSeoI18nTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'better_seo_i18n';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\BetterSeo\\Model\\BetterSeoI18n';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'BetterSeo.Model.BetterSeoI18n';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 22;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 22;

    /**
     * the column name for the ID field
     */
    const ID = 'better_seo_i18n.ID';

    /**
     * the column name for the LOCALE field
     */
    const LOCALE = 'better_seo_i18n.LOCALE';

    /**
     * the column name for the NOINDEX field
     */
    const NOINDEX = 'better_seo_i18n.NOINDEX';

    /**
     * the column name for the NOFOLLOW field
     */
    const NOFOLLOW = 'better_seo_i18n.NOFOLLOW';

    /**
     * the column name for the CANONICAL_FIELD field
     */
    const CANONICAL_FIELD = 'better_seo_i18n.CANONICAL_FIELD';

    /**
     * the column name for the H1 field
     */
    const H1 = 'better_seo_i18n.H1';

    /**
     * the column name for the MESH_TEXT_1 field
     */
    const MESH_TEXT_1 = 'better_seo_i18n.MESH_TEXT_1';

    /**
     * the column name for the MESH_URL_1 field
     */
    const MESH_URL_1 = 'better_seo_i18n.MESH_URL_1';

    /**
     * the column name for the MESH_TEXT_2 field
     */
    const MESH_TEXT_2 = 'better_seo_i18n.MESH_TEXT_2';

    /**
     * the column name for the MESH_URL_2 field
     */
    const MESH_URL_2 = 'better_seo_i18n.MESH_URL_2';

    /**
     * the column name for the MESH_TEXT_3 field
     */
    const MESH_TEXT_3 = 'better_seo_i18n.MESH_TEXT_3';

    /**
     * the column name for the MESH_URL_3 field
     */
    const MESH_URL_3 = 'better_seo_i18n.MESH_URL_3';

    /**
     * the column name for the MESH_TEXT_4 field
     */
    const MESH_TEXT_4 = 'better_seo_i18n.MESH_TEXT_4';

    /**
     * the column name for the MESH_URL_4 field
     */
    const MESH_URL_4 = 'better_seo_i18n.MESH_URL_4';

    /**
     * the column name for the MESH_TEXT_5 field
     */
    const MESH_TEXT_5 = 'better_seo_i18n.MESH_TEXT_5';

    /**
     * the column name for the MESH_URL_5 field
     */
    const MESH_URL_5 = 'better_seo_i18n.MESH_URL_5';

    /**
     * the column name for the MESH_1 field
     */
    const MESH_1 = 'better_seo_i18n.MESH_1';

    /**
     * the column name for the MESH_2 field
     */
    const MESH_2 = 'better_seo_i18n.MESH_2';

    /**
     * the column name for the MESH_3 field
     */
    const MESH_3 = 'better_seo_i18n.MESH_3';

    /**
     * the column name for the MESH_4 field
     */
    const MESH_4 = 'better_seo_i18n.MESH_4';

    /**
     * the column name for the MESH_5 field
     */
    const MESH_5 = 'better_seo_i18n.MESH_5';

    /**
     * the column name for the JSON_DATA field
     */
    const JSON_DATA = 'better_seo_i18n.JSON_DATA';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Locale', 'Noindex', 'Nofollow', 'CanonicalField', 'H1', 'MeshText1', 'MeshUrl1', 'MeshText2', 'MeshUrl2', 'MeshText3', 'MeshUrl3', 'MeshText4', 'MeshUrl4', 'MeshText5', 'MeshUrl5', 'Mesh1', 'Mesh2', 'Mesh3', 'Mesh4', 'Mesh5', 'JsonData', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'locale', 'noindex', 'nofollow', 'canonicalField', 'h1', 'meshText1', 'meshUrl1', 'meshText2', 'meshUrl2', 'meshText3', 'meshUrl3', 'meshText4', 'meshUrl4', 'meshText5', 'meshUrl5', 'mesh1', 'mesh2', 'mesh3', 'mesh4', 'mesh5', 'jsonData', ),
        self::TYPE_COLNAME       => array(BetterSeoI18nTableMap::ID, BetterSeoI18nTableMap::LOCALE, BetterSeoI18nTableMap::NOINDEX, BetterSeoI18nTableMap::NOFOLLOW, BetterSeoI18nTableMap::CANONICAL_FIELD, BetterSeoI18nTableMap::H1, BetterSeoI18nTableMap::MESH_TEXT_1, BetterSeoI18nTableMap::MESH_URL_1, BetterSeoI18nTableMap::MESH_TEXT_2, BetterSeoI18nTableMap::MESH_URL_2, BetterSeoI18nTableMap::MESH_TEXT_3, BetterSeoI18nTableMap::MESH_URL_3, BetterSeoI18nTableMap::MESH_TEXT_4, BetterSeoI18nTableMap::MESH_URL_4, BetterSeoI18nTableMap::MESH_TEXT_5, BetterSeoI18nTableMap::MESH_URL_5, BetterSeoI18nTableMap::MESH_1, BetterSeoI18nTableMap::MESH_2, BetterSeoI18nTableMap::MESH_3, BetterSeoI18nTableMap::MESH_4, BetterSeoI18nTableMap::MESH_5, BetterSeoI18nTableMap::JSON_DATA, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'LOCALE', 'NOINDEX', 'NOFOLLOW', 'CANONICAL_FIELD', 'H1', 'MESH_TEXT_1', 'MESH_URL_1', 'MESH_TEXT_2', 'MESH_URL_2', 'MESH_TEXT_3', 'MESH_URL_3', 'MESH_TEXT_4', 'MESH_URL_4', 'MESH_TEXT_5', 'MESH_URL_5', 'MESH_1', 'MESH_2', 'MESH_3', 'MESH_4', 'MESH_5', 'JSON_DATA', ),
        self::TYPE_FIELDNAME     => array('id', 'locale', 'noindex', 'nofollow', 'canonical_field', 'h1', 'mesh_text_1', 'mesh_url_1', 'mesh_text_2', 'mesh_url_2', 'mesh_text_3', 'mesh_url_3', 'mesh_text_4', 'mesh_url_4', 'mesh_text_5', 'mesh_url_5', 'mesh_1', 'mesh_2', 'mesh_3', 'mesh_4', 'mesh_5', 'json_data', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Locale' => 1, 'Noindex' => 2, 'Nofollow' => 3, 'CanonicalField' => 4, 'H1' => 5, 'MeshText1' => 6, 'MeshUrl1' => 7, 'MeshText2' => 8, 'MeshUrl2' => 9, 'MeshText3' => 10, 'MeshUrl3' => 11, 'MeshText4' => 12, 'MeshUrl4' => 13, 'MeshText5' => 14, 'MeshUrl5' => 15, 'Mesh1' => 16, 'Mesh2' => 17, 'Mesh3' => 18, 'Mesh4' => 19, 'Mesh5' => 20, 'JsonData' => 21, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'locale' => 1, 'noindex' => 2, 'nofollow' => 3, 'canonicalField' => 4, 'h1' => 5, 'meshText1' => 6, 'meshUrl1' => 7, 'meshText2' => 8, 'meshUrl2' => 9, 'meshText3' => 10, 'meshUrl3' => 11, 'meshText4' => 12, 'meshUrl4' => 13, 'meshText5' => 14, 'meshUrl5' => 15, 'mesh1' => 16, 'mesh2' => 17, 'mesh3' => 18, 'mesh4' => 19, 'mesh5' => 20, 'jsonData' => 21, ),
        self::TYPE_COLNAME       => array(BetterSeoI18nTableMap::ID => 0, BetterSeoI18nTableMap::LOCALE => 1, BetterSeoI18nTableMap::NOINDEX => 2, BetterSeoI18nTableMap::NOFOLLOW => 3, BetterSeoI18nTableMap::CANONICAL_FIELD => 4, BetterSeoI18nTableMap::H1 => 5, BetterSeoI18nTableMap::MESH_TEXT_1 => 6, BetterSeoI18nTableMap::MESH_URL_1 => 7, BetterSeoI18nTableMap::MESH_TEXT_2 => 8, BetterSeoI18nTableMap::MESH_URL_2 => 9, BetterSeoI18nTableMap::MESH_TEXT_3 => 10, BetterSeoI18nTableMap::MESH_URL_3 => 11, BetterSeoI18nTableMap::MESH_TEXT_4 => 12, BetterSeoI18nTableMap::MESH_URL_4 => 13, BetterSeoI18nTableMap::MESH_TEXT_5 => 14, BetterSeoI18nTableMap::MESH_URL_5 => 15, BetterSeoI18nTableMap::MESH_1 => 16, BetterSeoI18nTableMap::MESH_2 => 17, BetterSeoI18nTableMap::MESH_3 => 18, BetterSeoI18nTableMap::MESH_4 => 19, BetterSeoI18nTableMap::MESH_5 => 20, BetterSeoI18nTableMap::JSON_DATA => 21, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'LOCALE' => 1, 'NOINDEX' => 2, 'NOFOLLOW' => 3, 'CANONICAL_FIELD' => 4, 'H1' => 5, 'MESH_TEXT_1' => 6, 'MESH_URL_1' => 7, 'MESH_TEXT_2' => 8, 'MESH_URL_2' => 9, 'MESH_TEXT_3' => 10, 'MESH_URL_3' => 11, 'MESH_TEXT_4' => 12, 'MESH_URL_4' => 13, 'MESH_TEXT_5' => 14, 'MESH_URL_5' => 15, 'MESH_1' => 16, 'MESH_2' => 17, 'MESH_3' => 18, 'MESH_4' => 19, 'MESH_5' => 20, 'JSON_DATA' => 21, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'locale' => 1, 'noindex' => 2, 'nofollow' => 3, 'canonical_field' => 4, 'h1' => 5, 'mesh_text_1' => 6, 'mesh_url_1' => 7, 'mesh_text_2' => 8, 'mesh_url_2' => 9, 'mesh_text_3' => 10, 'mesh_url_3' => 11, 'mesh_text_4' => 12, 'mesh_url_4' => 13, 'mesh_text_5' => 14, 'mesh_url_5' => 15, 'mesh_1' => 16, 'mesh_2' => 17, 'mesh_3' => 18, 'mesh_4' => 19, 'mesh_5' => 20, 'json_data' => 21, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('better_seo_i18n');
        $this->setPhpName('BetterSeoI18n');
        $this->setClassName('\\BetterSeo\\Model\\BetterSeoI18n');
        $this->setPackage('BetterSeo.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'better_seo', 'ID', true, null, null);
        $this->addPrimaryKey('LOCALE', 'Locale', 'VARCHAR', true, 5, 'en_US');
        $this->addColumn('NOINDEX', 'Noindex', 'TINYINT', true, 4, 0);
        $this->addColumn('NOFOLLOW', 'Nofollow', 'TINYINT', true, 4, 0);
        $this->addColumn('CANONICAL_FIELD', 'CanonicalField', 'LONGVARCHAR', false, null, null);
        $this->addColumn('H1', 'H1', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_TEXT_1', 'MeshText1', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_URL_1', 'MeshUrl1', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_TEXT_2', 'MeshText2', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_URL_2', 'MeshUrl2', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_TEXT_3', 'MeshText3', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_URL_3', 'MeshUrl3', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_TEXT_4', 'MeshText4', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_URL_4', 'MeshUrl4', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_TEXT_5', 'MeshText5', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_URL_5', 'MeshUrl5', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_1', 'Mesh1', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_2', 'Mesh2', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_3', 'Mesh3', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_4', 'Mesh4', 'LONGVARCHAR', false, null, null);
        $this->addColumn('MESH_5', 'Mesh5', 'LONGVARCHAR', false, null, null);
        $this->addColumn('JSON_DATA', 'JsonData', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('BetterSeo', '\\BetterSeo\\Model\\BetterSeo', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \BetterSeo\Model\BetterSeoI18n $obj A \BetterSeo\Model\BetterSeoI18n object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getLocale()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \BetterSeo\Model\BetterSeoI18n object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \BetterSeo\Model\BetterSeoI18n) {
                $key = serialize(array((string) $value->getId(), (string) $value->getLocale()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \BetterSeo\Model\BetterSeoI18n object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)]));
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? BetterSeoI18nTableMap::CLASS_DEFAULT : BetterSeoI18nTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (BetterSeoI18n object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BetterSeoI18nTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BetterSeoI18nTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BetterSeoI18nTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BetterSeoI18nTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BetterSeoI18nTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = BetterSeoI18nTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BetterSeoI18nTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BetterSeoI18nTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(BetterSeoI18nTableMap::ID);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::LOCALE);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::NOINDEX);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::NOFOLLOW);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::CANONICAL_FIELD);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::H1);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_TEXT_1);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_URL_1);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_TEXT_2);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_URL_2);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_TEXT_3);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_URL_3);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_TEXT_4);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_URL_4);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_TEXT_5);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_URL_5);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_1);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_2);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_3);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_4);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::MESH_5);
            $criteria->addSelectColumn(BetterSeoI18nTableMap::JSON_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.LOCALE');
            $criteria->addSelectColumn($alias . '.NOINDEX');
            $criteria->addSelectColumn($alias . '.NOFOLLOW');
            $criteria->addSelectColumn($alias . '.CANONICAL_FIELD');
            $criteria->addSelectColumn($alias . '.H1');
            $criteria->addSelectColumn($alias . '.MESH_TEXT_1');
            $criteria->addSelectColumn($alias . '.MESH_URL_1');
            $criteria->addSelectColumn($alias . '.MESH_TEXT_2');
            $criteria->addSelectColumn($alias . '.MESH_URL_2');
            $criteria->addSelectColumn($alias . '.MESH_TEXT_3');
            $criteria->addSelectColumn($alias . '.MESH_URL_3');
            $criteria->addSelectColumn($alias . '.MESH_TEXT_4');
            $criteria->addSelectColumn($alias . '.MESH_URL_4');
            $criteria->addSelectColumn($alias . '.MESH_TEXT_5');
            $criteria->addSelectColumn($alias . '.MESH_URL_5');
            $criteria->addSelectColumn($alias . '.MESH_1');
            $criteria->addSelectColumn($alias . '.MESH_2');
            $criteria->addSelectColumn($alias . '.MESH_3');
            $criteria->addSelectColumn($alias . '.MESH_4');
            $criteria->addSelectColumn($alias . '.MESH_5');
            $criteria->addSelectColumn($alias . '.JSON_DATA');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(BetterSeoI18nTableMap::DATABASE_NAME)->getTable(BetterSeoI18nTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(BetterSeoI18nTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(BetterSeoI18nTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new BetterSeoI18nTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a BetterSeoI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BetterSeoI18n object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \BetterSeo\Model\BetterSeoI18n) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BetterSeoI18nTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(BetterSeoI18nTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(BetterSeoI18nTableMap::LOCALE, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = BetterSeoI18nQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { BetterSeoI18nTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { BetterSeoI18nTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the better_seo_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BetterSeoI18nQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BetterSeoI18n or Criteria object.
     *
     * @param mixed               $criteria Criteria or BetterSeoI18n object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BetterSeoI18n object
        }


        // Set the correct dbName
        $query = BetterSeoI18nQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // BetterSeoI18nTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BetterSeoI18nTableMap::buildTableMap();
