<?php

namespace BetterSeo\Model\Base;

use \Exception;
use \PDO;
use BetterSeo\Model\BetterSeoI18n as ChildBetterSeoI18n;
use BetterSeo\Model\BetterSeoI18nQuery as ChildBetterSeoI18nQuery;
use BetterSeo\Model\Map\BetterSeoI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'better_seo_i18n' table.
 *
 *
 *
 * @method     ChildBetterSeoI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBetterSeoI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildBetterSeoI18nQuery orderByNoindex($order = Criteria::ASC) Order by the noindex column
 * @method     ChildBetterSeoI18nQuery orderByNofollow($order = Criteria::ASC) Order by the nofollow column
 * @method     ChildBetterSeoI18nQuery orderByCanonicalField($order = Criteria::ASC) Order by the canonical_field column
 * @method     ChildBetterSeoI18nQuery orderByH1($order = Criteria::ASC) Order by the h1 column
 *
 * @method     ChildBetterSeoI18nQuery groupById() Group by the id column
 * @method     ChildBetterSeoI18nQuery groupByLocale() Group by the locale column
 * @method     ChildBetterSeoI18nQuery groupByNoindex() Group by the noindex column
 * @method     ChildBetterSeoI18nQuery groupByNofollow() Group by the nofollow column
 * @method     ChildBetterSeoI18nQuery groupByCanonicalField() Group by the canonical_field column
 * @method     ChildBetterSeoI18nQuery groupByH1() Group by the h1 column
 *
 * @method     ChildBetterSeoI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBetterSeoI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBetterSeoI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBetterSeoI18nQuery leftJoinBetterSeo($relationAlias = null) Adds a LEFT JOIN clause to the query using the BetterSeo relation
 * @method     ChildBetterSeoI18nQuery rightJoinBetterSeo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BetterSeo relation
 * @method     ChildBetterSeoI18nQuery innerJoinBetterSeo($relationAlias = null) Adds a INNER JOIN clause to the query using the BetterSeo relation
 *
 * @method     ChildBetterSeoI18n findOne(ConnectionInterface $con = null) Return the first ChildBetterSeoI18n matching the query
 * @method     ChildBetterSeoI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBetterSeoI18n matching the query, or a new ChildBetterSeoI18n object populated from the query conditions when no match is found
 *
 * @method     ChildBetterSeoI18n findOneById(int $id) Return the first ChildBetterSeoI18n filtered by the id column
 * @method     ChildBetterSeoI18n findOneByLocale(string $locale) Return the first ChildBetterSeoI18n filtered by the locale column
 * @method     ChildBetterSeoI18n findOneByNoindex(int $noindex) Return the first ChildBetterSeoI18n filtered by the noindex column
 * @method     ChildBetterSeoI18n findOneByNofollow(int $nofollow) Return the first ChildBetterSeoI18n filtered by the nofollow column
 * @method     ChildBetterSeoI18n findOneByCanonicalField(string $canonical_field) Return the first ChildBetterSeoI18n filtered by the canonical_field column
 * @method     ChildBetterSeoI18n findOneByH1(string $h1) Return the first ChildBetterSeoI18n filtered by the h1 column
 *
 * @method     array findById(int $id) Return ChildBetterSeoI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildBetterSeoI18n objects filtered by the locale column
 * @method     array findByNoindex(int $noindex) Return ChildBetterSeoI18n objects filtered by the noindex column
 * @method     array findByNofollow(int $nofollow) Return ChildBetterSeoI18n objects filtered by the nofollow column
 * @method     array findByCanonicalField(string $canonical_field) Return ChildBetterSeoI18n objects filtered by the canonical_field column
 * @method     array findByH1(string $h1) Return ChildBetterSeoI18n objects filtered by the h1 column
 *
 */
abstract class BetterSeoI18nQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \BetterSeo\Model\Base\BetterSeoI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\BetterSeo\\Model\\BetterSeoI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBetterSeoI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBetterSeoI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \BetterSeo\Model\BetterSeoI18nQuery) {
            return $criteria;
        }
        $query = new \BetterSeo\Model\BetterSeoI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBetterSeoI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BetterSeoI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BetterSeoI18nTableMap::DATABASE_NAME);
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
     * @return   ChildBetterSeoI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, NOINDEX, NOFOLLOW, CANONICAL_FIELD, H1 FROM better_seo_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildBetterSeoI18n();
            $obj->hydrate($row);
            BetterSeoI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildBetterSeoI18n|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(BetterSeoI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(BetterSeoI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(BetterSeoI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(BetterSeoI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByBetterSeo()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::LOCALE, $locale, $comparison);
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
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByNoindex($noindex = null, $comparison = null)
    {
        if (is_array($noindex)) {
            $useMinMax = false;
            if (isset($noindex['min'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::NOINDEX, $noindex['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($noindex['max'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::NOINDEX, $noindex['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::NOINDEX, $noindex, $comparison);
    }

    /**
     * Filter the query on the nofollow column
     *
     * Example usage:
     * <code>
     * $query->filterByNofollow(1234); // WHERE nofollow = 1234
     * $query->filterByNofollow(array(12, 34)); // WHERE nofollow IN (12, 34)
     * $query->filterByNofollow(array('min' => 12)); // WHERE nofollow > 12
     * </code>
     *
     * @param     mixed $nofollow The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByNofollow($nofollow = null, $comparison = null)
    {
        if (is_array($nofollow)) {
            $useMinMax = false;
            if (isset($nofollow['min'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::NOFOLLOW, $nofollow['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nofollow['max'])) {
                $this->addUsingAlias(BetterSeoI18nTableMap::NOFOLLOW, $nofollow['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::NOFOLLOW, $nofollow, $comparison);
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
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BetterSeoI18nTableMap::CANONICAL_FIELD, $canonicalField, $comparison);
    }

    /**
     * Filter the query on the h1 column
     *
     * Example usage:
     * <code>
     * $query->filterByH1('fooValue');   // WHERE h1 = 'fooValue'
     * $query->filterByH1('%fooValue%'); // WHERE h1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $h1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByH1($h1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($h1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $h1)) {
                $h1 = str_replace('*', '%', $h1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::H1, $h1, $comparison);
    }

    /**
     * Filter the query by a related \BetterSeo\Model\BetterSeo object
     *
     * @param \BetterSeo\Model\BetterSeo|ObjectCollection $betterSeo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByBetterSeo($betterSeo, $comparison = null)
    {
        if ($betterSeo instanceof \BetterSeo\Model\BetterSeo) {
            return $this
                ->addUsingAlias(BetterSeoI18nTableMap::ID, $betterSeo->getId(), $comparison);
        } elseif ($betterSeo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BetterSeoI18nTableMap::ID, $betterSeo->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBetterSeo() only accepts arguments of type \BetterSeo\Model\BetterSeo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BetterSeo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function joinBetterSeo($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BetterSeo');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BetterSeo');
        }

        return $this;
    }

    /**
     * Use the BetterSeo relation BetterSeo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \BetterSeo\Model\BetterSeoQuery A secondary query class using the current class as primary query
     */
    public function useBetterSeoQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinBetterSeo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BetterSeo', '\BetterSeo\Model\BetterSeoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBetterSeoI18n $betterSeoI18n Object to remove from the list of results
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function prune($betterSeoI18n = null)
    {
        if ($betterSeoI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(BetterSeoI18nTableMap::ID), $betterSeoI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(BetterSeoI18nTableMap::LOCALE), $betterSeoI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the better_seo_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
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
            BetterSeoI18nTableMap::clearInstancePool();
            BetterSeoI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildBetterSeoI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildBetterSeoI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BetterSeoI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BetterSeoI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        BetterSeoI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BetterSeoI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // BetterSeoI18nQuery
