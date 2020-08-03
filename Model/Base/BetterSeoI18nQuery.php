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
 * @method     ChildBetterSeoI18nQuery orderByMeshText1($order = Criteria::ASC) Order by the mesh_text_1 column
 * @method     ChildBetterSeoI18nQuery orderByMeshUrl1($order = Criteria::ASC) Order by the mesh_url_1 column
 * @method     ChildBetterSeoI18nQuery orderByMeshText2($order = Criteria::ASC) Order by the mesh_text_2 column
 * @method     ChildBetterSeoI18nQuery orderByMeshUrl2($order = Criteria::ASC) Order by the mesh_url_2 column
 * @method     ChildBetterSeoI18nQuery orderByMeshText3($order = Criteria::ASC) Order by the mesh_text_3 column
 * @method     ChildBetterSeoI18nQuery orderByMeshUrl3($order = Criteria::ASC) Order by the mesh_url_3 column
 * @method     ChildBetterSeoI18nQuery orderByMeshText4($order = Criteria::ASC) Order by the mesh_text_4 column
 * @method     ChildBetterSeoI18nQuery orderByMeshUrl4($order = Criteria::ASC) Order by the mesh_url_4 column
 * @method     ChildBetterSeoI18nQuery orderByMeshText5($order = Criteria::ASC) Order by the mesh_text_5 column
 * @method     ChildBetterSeoI18nQuery orderByMeshUrl5($order = Criteria::ASC) Order by the mesh_url_5 column
 * @method     ChildBetterSeoI18nQuery orderByMesh1($order = Criteria::ASC) Order by the mesh_1 column
 * @method     ChildBetterSeoI18nQuery orderByMesh2($order = Criteria::ASC) Order by the mesh_2 column
 * @method     ChildBetterSeoI18nQuery orderByMesh3($order = Criteria::ASC) Order by the mesh_3 column
 * @method     ChildBetterSeoI18nQuery orderByMesh4($order = Criteria::ASC) Order by the mesh_4 column
 * @method     ChildBetterSeoI18nQuery orderByMesh5($order = Criteria::ASC) Order by the mesh_5 column
 *
 * @method     ChildBetterSeoI18nQuery groupById() Group by the id column
 * @method     ChildBetterSeoI18nQuery groupByLocale() Group by the locale column
 * @method     ChildBetterSeoI18nQuery groupByNoindex() Group by the noindex column
 * @method     ChildBetterSeoI18nQuery groupByNofollow() Group by the nofollow column
 * @method     ChildBetterSeoI18nQuery groupByCanonicalField() Group by the canonical_field column
 * @method     ChildBetterSeoI18nQuery groupByH1() Group by the h1 column
 * @method     ChildBetterSeoI18nQuery groupByMeshText1() Group by the mesh_text_1 column
 * @method     ChildBetterSeoI18nQuery groupByMeshUrl1() Group by the mesh_url_1 column
 * @method     ChildBetterSeoI18nQuery groupByMeshText2() Group by the mesh_text_2 column
 * @method     ChildBetterSeoI18nQuery groupByMeshUrl2() Group by the mesh_url_2 column
 * @method     ChildBetterSeoI18nQuery groupByMeshText3() Group by the mesh_text_3 column
 * @method     ChildBetterSeoI18nQuery groupByMeshUrl3() Group by the mesh_url_3 column
 * @method     ChildBetterSeoI18nQuery groupByMeshText4() Group by the mesh_text_4 column
 * @method     ChildBetterSeoI18nQuery groupByMeshUrl4() Group by the mesh_url_4 column
 * @method     ChildBetterSeoI18nQuery groupByMeshText5() Group by the mesh_text_5 column
 * @method     ChildBetterSeoI18nQuery groupByMeshUrl5() Group by the mesh_url_5 column
 * @method     ChildBetterSeoI18nQuery groupByMesh1() Group by the mesh_1 column
 * @method     ChildBetterSeoI18nQuery groupByMesh2() Group by the mesh_2 column
 * @method     ChildBetterSeoI18nQuery groupByMesh3() Group by the mesh_3 column
 * @method     ChildBetterSeoI18nQuery groupByMesh4() Group by the mesh_4 column
 * @method     ChildBetterSeoI18nQuery groupByMesh5() Group by the mesh_5 column
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
 * @method     ChildBetterSeoI18n findOneByMeshText1(string $mesh_text_1) Return the first ChildBetterSeoI18n filtered by the mesh_text_1 column
 * @method     ChildBetterSeoI18n findOneByMeshUrl1(string $mesh_url_1) Return the first ChildBetterSeoI18n filtered by the mesh_url_1 column
 * @method     ChildBetterSeoI18n findOneByMeshText2(string $mesh_text_2) Return the first ChildBetterSeoI18n filtered by the mesh_text_2 column
 * @method     ChildBetterSeoI18n findOneByMeshUrl2(string $mesh_url_2) Return the first ChildBetterSeoI18n filtered by the mesh_url_2 column
 * @method     ChildBetterSeoI18n findOneByMeshText3(string $mesh_text_3) Return the first ChildBetterSeoI18n filtered by the mesh_text_3 column
 * @method     ChildBetterSeoI18n findOneByMeshUrl3(string $mesh_url_3) Return the first ChildBetterSeoI18n filtered by the mesh_url_3 column
 * @method     ChildBetterSeoI18n findOneByMeshText4(string $mesh_text_4) Return the first ChildBetterSeoI18n filtered by the mesh_text_4 column
 * @method     ChildBetterSeoI18n findOneByMeshUrl4(string $mesh_url_4) Return the first ChildBetterSeoI18n filtered by the mesh_url_4 column
 * @method     ChildBetterSeoI18n findOneByMeshText5(string $mesh_text_5) Return the first ChildBetterSeoI18n filtered by the mesh_text_5 column
 * @method     ChildBetterSeoI18n findOneByMeshUrl5(string $mesh_url_5) Return the first ChildBetterSeoI18n filtered by the mesh_url_5 column
 * @method     ChildBetterSeoI18n findOneByMesh1(string $mesh_1) Return the first ChildBetterSeoI18n filtered by the mesh_1 column
 * @method     ChildBetterSeoI18n findOneByMesh2(string $mesh_2) Return the first ChildBetterSeoI18n filtered by the mesh_2 column
 * @method     ChildBetterSeoI18n findOneByMesh3(string $mesh_3) Return the first ChildBetterSeoI18n filtered by the mesh_3 column
 * @method     ChildBetterSeoI18n findOneByMesh4(string $mesh_4) Return the first ChildBetterSeoI18n filtered by the mesh_4 column
 * @method     ChildBetterSeoI18n findOneByMesh5(string $mesh_5) Return the first ChildBetterSeoI18n filtered by the mesh_5 column
 *
 * @method     array findById(int $id) Return ChildBetterSeoI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildBetterSeoI18n objects filtered by the locale column
 * @method     array findByNoindex(int $noindex) Return ChildBetterSeoI18n objects filtered by the noindex column
 * @method     array findByNofollow(int $nofollow) Return ChildBetterSeoI18n objects filtered by the nofollow column
 * @method     array findByCanonicalField(string $canonical_field) Return ChildBetterSeoI18n objects filtered by the canonical_field column
 * @method     array findByH1(string $h1) Return ChildBetterSeoI18n objects filtered by the h1 column
 * @method     array findByMeshText1(string $mesh_text_1) Return ChildBetterSeoI18n objects filtered by the mesh_text_1 column
 * @method     array findByMeshUrl1(string $mesh_url_1) Return ChildBetterSeoI18n objects filtered by the mesh_url_1 column
 * @method     array findByMeshText2(string $mesh_text_2) Return ChildBetterSeoI18n objects filtered by the mesh_text_2 column
 * @method     array findByMeshUrl2(string $mesh_url_2) Return ChildBetterSeoI18n objects filtered by the mesh_url_2 column
 * @method     array findByMeshText3(string $mesh_text_3) Return ChildBetterSeoI18n objects filtered by the mesh_text_3 column
 * @method     array findByMeshUrl3(string $mesh_url_3) Return ChildBetterSeoI18n objects filtered by the mesh_url_3 column
 * @method     array findByMeshText4(string $mesh_text_4) Return ChildBetterSeoI18n objects filtered by the mesh_text_4 column
 * @method     array findByMeshUrl4(string $mesh_url_4) Return ChildBetterSeoI18n objects filtered by the mesh_url_4 column
 * @method     array findByMeshText5(string $mesh_text_5) Return ChildBetterSeoI18n objects filtered by the mesh_text_5 column
 * @method     array findByMeshUrl5(string $mesh_url_5) Return ChildBetterSeoI18n objects filtered by the mesh_url_5 column
 * @method     array findByMesh1(string $mesh_1) Return ChildBetterSeoI18n objects filtered by the mesh_1 column
 * @method     array findByMesh2(string $mesh_2) Return ChildBetterSeoI18n objects filtered by the mesh_2 column
 * @method     array findByMesh3(string $mesh_3) Return ChildBetterSeoI18n objects filtered by the mesh_3 column
 * @method     array findByMesh4(string $mesh_4) Return ChildBetterSeoI18n objects filtered by the mesh_4 column
 * @method     array findByMesh5(string $mesh_5) Return ChildBetterSeoI18n objects filtered by the mesh_5 column
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
        $sql = 'SELECT ID, LOCALE, NOINDEX, NOFOLLOW, CANONICAL_FIELD, H1, MESH_TEXT_1, MESH_URL_1, MESH_TEXT_2, MESH_URL_2, MESH_TEXT_3, MESH_URL_3, MESH_TEXT_4, MESH_URL_4, MESH_TEXT_5, MESH_URL_5, MESH_1, MESH_2, MESH_3, MESH_4, MESH_5 FROM better_seo_i18n WHERE ID = :p0 AND LOCALE = :p1';
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
     * Filter the query on the mesh_text_1 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshText1('fooValue');   // WHERE mesh_text_1 = 'fooValue'
     * $query->filterByMeshText1('%fooValue%'); // WHERE mesh_text_1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshText1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshText1($meshText1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshText1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshText1)) {
                $meshText1 = str_replace('*', '%', $meshText1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_TEXT_1, $meshText1, $comparison);
    }

    /**
     * Filter the query on the mesh_url_1 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshUrl1('fooValue');   // WHERE mesh_url_1 = 'fooValue'
     * $query->filterByMeshUrl1('%fooValue%'); // WHERE mesh_url_1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshUrl1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshUrl1($meshUrl1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshUrl1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshUrl1)) {
                $meshUrl1 = str_replace('*', '%', $meshUrl1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_URL_1, $meshUrl1, $comparison);
    }

    /**
     * Filter the query on the mesh_text_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshText2('fooValue');   // WHERE mesh_text_2 = 'fooValue'
     * $query->filterByMeshText2('%fooValue%'); // WHERE mesh_text_2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshText2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshText2($meshText2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshText2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshText2)) {
                $meshText2 = str_replace('*', '%', $meshText2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_TEXT_2, $meshText2, $comparison);
    }

    /**
     * Filter the query on the mesh_url_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshUrl2('fooValue');   // WHERE mesh_url_2 = 'fooValue'
     * $query->filterByMeshUrl2('%fooValue%'); // WHERE mesh_url_2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshUrl2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshUrl2($meshUrl2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshUrl2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshUrl2)) {
                $meshUrl2 = str_replace('*', '%', $meshUrl2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_URL_2, $meshUrl2, $comparison);
    }

    /**
     * Filter the query on the mesh_text_3 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshText3('fooValue');   // WHERE mesh_text_3 = 'fooValue'
     * $query->filterByMeshText3('%fooValue%'); // WHERE mesh_text_3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshText3 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshText3($meshText3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshText3)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshText3)) {
                $meshText3 = str_replace('*', '%', $meshText3);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_TEXT_3, $meshText3, $comparison);
    }

    /**
     * Filter the query on the mesh_url_3 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshUrl3('fooValue');   // WHERE mesh_url_3 = 'fooValue'
     * $query->filterByMeshUrl3('%fooValue%'); // WHERE mesh_url_3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshUrl3 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshUrl3($meshUrl3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshUrl3)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshUrl3)) {
                $meshUrl3 = str_replace('*', '%', $meshUrl3);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_URL_3, $meshUrl3, $comparison);
    }

    /**
     * Filter the query on the mesh_text_4 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshText4('fooValue');   // WHERE mesh_text_4 = 'fooValue'
     * $query->filterByMeshText4('%fooValue%'); // WHERE mesh_text_4 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshText4 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshText4($meshText4 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshText4)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshText4)) {
                $meshText4 = str_replace('*', '%', $meshText4);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_TEXT_4, $meshText4, $comparison);
    }

    /**
     * Filter the query on the mesh_url_4 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshUrl4('fooValue');   // WHERE mesh_url_4 = 'fooValue'
     * $query->filterByMeshUrl4('%fooValue%'); // WHERE mesh_url_4 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshUrl4 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshUrl4($meshUrl4 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshUrl4)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshUrl4)) {
                $meshUrl4 = str_replace('*', '%', $meshUrl4);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_URL_4, $meshUrl4, $comparison);
    }

    /**
     * Filter the query on the mesh_text_5 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshText5('fooValue');   // WHERE mesh_text_5 = 'fooValue'
     * $query->filterByMeshText5('%fooValue%'); // WHERE mesh_text_5 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshText5 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshText5($meshText5 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshText5)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshText5)) {
                $meshText5 = str_replace('*', '%', $meshText5);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_TEXT_5, $meshText5, $comparison);
    }

    /**
     * Filter the query on the mesh_url_5 column
     *
     * Example usage:
     * <code>
     * $query->filterByMeshUrl5('fooValue');   // WHERE mesh_url_5 = 'fooValue'
     * $query->filterByMeshUrl5('%fooValue%'); // WHERE mesh_url_5 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meshUrl5 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeshUrl5($meshUrl5 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meshUrl5)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $meshUrl5)) {
                $meshUrl5 = str_replace('*', '%', $meshUrl5);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_URL_5, $meshUrl5, $comparison);
    }

    /**
     * Filter the query on the mesh_1 column
     *
     * Example usage:
     * <code>
     * $query->filterByMesh1('fooValue');   // WHERE mesh_1 = 'fooValue'
     * $query->filterByMesh1('%fooValue%'); // WHERE mesh_1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mesh1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMesh1($mesh1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mesh1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mesh1)) {
                $mesh1 = str_replace('*', '%', $mesh1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_1, $mesh1, $comparison);
    }

    /**
     * Filter the query on the mesh_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByMesh2('fooValue');   // WHERE mesh_2 = 'fooValue'
     * $query->filterByMesh2('%fooValue%'); // WHERE mesh_2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mesh2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMesh2($mesh2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mesh2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mesh2)) {
                $mesh2 = str_replace('*', '%', $mesh2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_2, $mesh2, $comparison);
    }

    /**
     * Filter the query on the mesh_3 column
     *
     * Example usage:
     * <code>
     * $query->filterByMesh3('fooValue');   // WHERE mesh_3 = 'fooValue'
     * $query->filterByMesh3('%fooValue%'); // WHERE mesh_3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mesh3 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMesh3($mesh3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mesh3)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mesh3)) {
                $mesh3 = str_replace('*', '%', $mesh3);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_3, $mesh3, $comparison);
    }

    /**
     * Filter the query on the mesh_4 column
     *
     * Example usage:
     * <code>
     * $query->filterByMesh4('fooValue');   // WHERE mesh_4 = 'fooValue'
     * $query->filterByMesh4('%fooValue%'); // WHERE mesh_4 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mesh4 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMesh4($mesh4 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mesh4)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mesh4)) {
                $mesh4 = str_replace('*', '%', $mesh4);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_4, $mesh4, $comparison);
    }

    /**
     * Filter the query on the mesh_5 column
     *
     * Example usage:
     * <code>
     * $query->filterByMesh5('fooValue');   // WHERE mesh_5 = 'fooValue'
     * $query->filterByMesh5('%fooValue%'); // WHERE mesh_5 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mesh5 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBetterSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMesh5($mesh5 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mesh5)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mesh5)) {
                $mesh5 = str_replace('*', '%', $mesh5);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BetterSeoI18nTableMap::MESH_5, $mesh5, $comparison);
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
