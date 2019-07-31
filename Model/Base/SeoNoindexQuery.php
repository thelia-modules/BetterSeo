<?php

namespace BetterSeo\Model\Base;

use \Exception;
use \PDO;
use BetterSeo\Model\SeoNoindex as ChildSeoNoindex;
use BetterSeo\Model\SeoNoindexQuery as ChildSeoNoindexQuery;
use BetterSeo\Model\Map\SeoNoindexTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'seo_noindex' table.
 *
 *
 *
 * @method     ChildSeoNoindexQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSeoNoindexQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method     ChildSeoNoindexQuery orderByObjectType($order = Criteria::ASC) Order by the object_type column
 * @method     ChildSeoNoindexQuery orderByNoindex($order = Criteria::ASC) Order by the noindex column
 * @method     ChildSeoNoindexQuery orderByCanonicalField($order = Criteria::ASC) Order by the canonical_field column
 *
 * @method     ChildSeoNoindexQuery groupById() Group by the id column
 * @method     ChildSeoNoindexQuery groupByObjectId() Group by the object_id column
 * @method     ChildSeoNoindexQuery groupByObjectType() Group by the object_type column
 * @method     ChildSeoNoindexQuery groupByNoindex() Group by the noindex column
 * @method     ChildSeoNoindexQuery groupByCanonicalField() Group by the canonical_field column
 *
 * @method     ChildSeoNoindexQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSeoNoindexQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSeoNoindexQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSeoNoindex findOne(ConnectionInterface $con = null) Return the first ChildSeoNoindex matching the query
 * @method     ChildSeoNoindex findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSeoNoindex matching the query, or a new ChildSeoNoindex object populated from the query conditions when no match is found
 *
 * @method     ChildSeoNoindex findOneById(int $id) Return the first ChildSeoNoindex filtered by the id column
 * @method     ChildSeoNoindex findOneByObjectId(int $object_id) Return the first ChildSeoNoindex filtered by the object_id column
 * @method     ChildSeoNoindex findOneByObjectType(string $object_type) Return the first ChildSeoNoindex filtered by the object_type column
 * @method     ChildSeoNoindex findOneByNoindex(int $noindex) Return the first ChildSeoNoindex filtered by the noindex column
 * @method     ChildSeoNoindex findOneByCanonicalField(string $canonical_field) Return the first ChildSeoNoindex filtered by the canonical_field column
 *
 * @method     array findById(int $id) Return ChildSeoNoindex objects filtered by the id column
 * @method     array findByObjectId(int $object_id) Return ChildSeoNoindex objects filtered by the object_id column
 * @method     array findByObjectType(string $object_type) Return ChildSeoNoindex objects filtered by the object_type column
 * @method     array findByNoindex(int $noindex) Return ChildSeoNoindex objects filtered by the noindex column
 * @method     array findByCanonicalField(string $canonical_field) Return ChildSeoNoindex objects filtered by the canonical_field column
 *
 */
abstract class SeoNoindexQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \BetterSeo\Model\Base\SeoNoindexQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\BetterSeo\\Model\\SeoNoindex', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSeoNoindexQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSeoNoindexQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \BetterSeo\Model\SeoNoindexQuery) {
            return $criteria;
        }
        $query = new \BetterSeo\Model\SeoNoindexQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSeoNoindex|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SeoNoindexTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SeoNoindexTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildSeoNoindex A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, OBJECT_ID, OBJECT_TYPE, NOINDEX, CANONICAL_FIELD FROM seo_noindex WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildSeoNoindex();
            $obj->hydrate($row);
            SeoNoindexTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSeoNoindex|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SeoNoindexTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SeoNoindexTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SeoNoindexTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SeoNoindexTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeoNoindexTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the object_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectId(1234); // WHERE object_id = 1234
     * $query->filterByObjectId(array(12, 34)); // WHERE object_id IN (12, 34)
     * $query->filterByObjectId(array('min' => 12)); // WHERE object_id > 12
     * </code>
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(SeoNoindexTableMap::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(SeoNoindexTableMap::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeoNoindexTableMap::OBJECT_ID, $objectId, $comparison);
    }

    /**
     * Filter the query on the object_type column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectType('fooValue');   // WHERE object_type = 'fooValue'
     * $query->filterByObjectType('%fooValue%'); // WHERE object_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $objectType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByObjectType($objectType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($objectType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $objectType)) {
                $objectType = str_replace('*', '%', $objectType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeoNoindexTableMap::OBJECT_TYPE, $objectType, $comparison);
    }

    /**
     * Filter the query on the noindex column
     *
     * Example usage:
     * <code>
     * $query->filterByNoindex(1234); // WHERE noindex = 1234
     * $query->filterByNoindex(array(12, 34)); // WHERE noindex IN (12, 34)
     * $query->filterByNoindex(array('min' => 12)); // WHERE noindex > 12
     * </code>
     *
     * @param     mixed $noindex The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByNoindex($noindex = null, $comparison = null)
    {
        if (is_array($noindex)) {
            $useMinMax = false;
            if (isset($noindex['min'])) {
                $this->addUsingAlias(SeoNoindexTableMap::NOINDEX, $noindex['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($noindex['max'])) {
                $this->addUsingAlias(SeoNoindexTableMap::NOINDEX, $noindex['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeoNoindexTableMap::NOINDEX, $noindex, $comparison);
    }

    /**
     * Filter the query on the canonical_field column
     *
     * Example usage:
     * <code>
     * $query->filterByCanonicalField('fooValue');   // WHERE canonical_field = 'fooValue'
     * $query->filterByCanonicalField('%fooValue%'); // WHERE canonical_field LIKE '%fooValue%'
     * </code>
     *
     * @param     string $canonicalField The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function filterByCanonicalField($canonicalField = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($canonicalField)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $canonicalField)) {
                $canonicalField = str_replace('*', '%', $canonicalField);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeoNoindexTableMap::CANONICAL_FIELD, $canonicalField, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSeoNoindex $seoNoindex Object to remove from the list of results
     *
     * @return ChildSeoNoindexQuery The current query, for fluid interface
     */
    public function prune($seoNoindex = null)
    {
        if ($seoNoindex) {
            $this->addUsingAlias(SeoNoindexTableMap::ID, $seoNoindex->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the seo_noindex table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SeoNoindexTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SeoNoindexTableMap::clearInstancePool();
            SeoNoindexTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSeoNoindex or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSeoNoindex object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SeoNoindexTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SeoNoindexTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        SeoNoindexTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SeoNoindexTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // SeoNoindexQuery
