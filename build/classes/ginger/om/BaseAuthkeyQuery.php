<?php


/**
 * Base class that represents a query for the 'authkey' table.
 *
 *
 *
 * @method AuthkeyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AuthkeyQuery orderByAsso($order = Criteria::ASC) Order by the asso column
 * @method AuthkeyQuery orderByDetails($order = Criteria::ASC) Order by the details column
 * @method AuthkeyQuery orderByCle($order = Criteria::ASC) Order by the cle column
 * @method AuthkeyQuery orderByDroitEcriture($order = Criteria::ASC) Order by the droit_ecriture column
 * @method AuthkeyQuery orderByDroitBadges($order = Criteria::ASC) Order by the droit_badges column
 * @method AuthkeyQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method AuthkeyQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method AuthkeyQuery groupById() Group by the id column
 * @method AuthkeyQuery groupByAsso() Group by the asso column
 * @method AuthkeyQuery groupByDetails() Group by the details column
 * @method AuthkeyQuery groupByCle() Group by the cle column
 * @method AuthkeyQuery groupByDroitEcriture() Group by the droit_ecriture column
 * @method AuthkeyQuery groupByDroitBadges() Group by the droit_badges column
 * @method AuthkeyQuery groupByCreatedAt() Group by the created_at column
 * @method AuthkeyQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method AuthkeyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AuthkeyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AuthkeyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Authkey findOne(PropelPDO $con = null) Return the first Authkey matching the query
 * @method Authkey findOneOrCreate(PropelPDO $con = null) Return the first Authkey matching the query, or a new Authkey object populated from the query conditions when no match is found
 *
 * @method Authkey findOneByAsso(string $asso) Return the first Authkey filtered by the asso column
 * @method Authkey findOneByDetails(string $details) Return the first Authkey filtered by the details column
 * @method Authkey findOneByCle(string $cle) Return the first Authkey filtered by the cle column
 * @method Authkey findOneByDroitEcriture(int $droit_ecriture) Return the first Authkey filtered by the droit_ecriture column
 * @method Authkey findOneByDroitBadges(int $droit_badges) Return the first Authkey filtered by the droit_badges column
 * @method Authkey findOneByCreatedAt(string $created_at) Return the first Authkey filtered by the created_at column
 * @method Authkey findOneByUpdatedAt(string $updated_at) Return the first Authkey filtered by the updated_at column
 *
 * @method array findById(int $id) Return Authkey objects filtered by the id column
 * @method array findByAsso(string $asso) Return Authkey objects filtered by the asso column
 * @method array findByDetails(string $details) Return Authkey objects filtered by the details column
 * @method array findByCle(string $cle) Return Authkey objects filtered by the cle column
 * @method array findByDroitEcriture(int $droit_ecriture) Return Authkey objects filtered by the droit_ecriture column
 * @method array findByDroitBadges(int $droit_badges) Return Authkey objects filtered by the droit_badges column
 * @method array findByCreatedAt(string $created_at) Return Authkey objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Authkey objects filtered by the updated_at column
 *
 * @package    propel.generator.ginger.om
 */
abstract class BaseAuthkeyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthkeyQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ginger', $modelName = 'Authkey', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthkeyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     AuthkeyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthkeyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthkeyQuery) {
            return $criteria;
        }
        $query = new AuthkeyQuery();
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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Authkey|Authkey[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthkeyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthkeyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   Authkey A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   Authkey A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `ASSO`, `DETAILS`, `CLE`, `DROIT_ECRITURE`, `DROIT_BADGES`, `CREATED_AT`, `UPDATED_AT` FROM `authkey` WHERE `ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Authkey();
            $obj->hydrate($row);
            AuthkeyPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Authkey|Authkey[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Authkey[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthkeyPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthkeyPeer::ID, $keys, Criteria::IN);
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
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(AuthkeyPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the asso column
     *
     * Example usage:
     * <code>
     * $query->filterByAsso('fooValue');   // WHERE asso = 'fooValue'
     * $query->filterByAsso('%fooValue%'); // WHERE asso LIKE '%fooValue%'
     * </code>
     *
     * @param     string $asso The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByAsso($asso = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($asso)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $asso)) {
                $asso = str_replace('*', '%', $asso);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::ASSO, $asso, $comparison);
    }

    /**
     * Filter the query on the details column
     *
     * Example usage:
     * <code>
     * $query->filterByDetails('fooValue');   // WHERE details = 'fooValue'
     * $query->filterByDetails('%fooValue%'); // WHERE details LIKE '%fooValue%'
     * </code>
     *
     * @param     string $details The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByDetails($details = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($details)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $details)) {
                $details = str_replace('*', '%', $details);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::DETAILS, $details, $comparison);
    }

    /**
     * Filter the query on the cle column
     *
     * Example usage:
     * <code>
     * $query->filterByCle('fooValue');   // WHERE cle = 'fooValue'
     * $query->filterByCle('%fooValue%'); // WHERE cle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByCle($cle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cle)) {
                $cle = str_replace('*', '%', $cle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::CLE, $cle, $comparison);
    }

    /**
     * Filter the query on the droit_ecriture column
     *
     * Example usage:
     * <code>
     * $query->filterByDroitEcriture(1234); // WHERE droit_ecriture = 1234
     * $query->filterByDroitEcriture(array(12, 34)); // WHERE droit_ecriture IN (12, 34)
     * $query->filterByDroitEcriture(array('min' => 12)); // WHERE droit_ecriture > 12
     * </code>
     *
     * @param     mixed $droitEcriture The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByDroitEcriture($droitEcriture = null, $comparison = null)
    {
        if (is_array($droitEcriture)) {
            $useMinMax = false;
            if (isset($droitEcriture['min'])) {
                $this->addUsingAlias(AuthkeyPeer::DROIT_ECRITURE, $droitEcriture['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($droitEcriture['max'])) {
                $this->addUsingAlias(AuthkeyPeer::DROIT_ECRITURE, $droitEcriture['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::DROIT_ECRITURE, $droitEcriture, $comparison);
    }

    /**
     * Filter the query on the droit_badges column
     *
     * Example usage:
     * <code>
     * $query->filterByDroitBadges(1234); // WHERE droit_badges = 1234
     * $query->filterByDroitBadges(array(12, 34)); // WHERE droit_badges IN (12, 34)
     * $query->filterByDroitBadges(array('min' => 12)); // WHERE droit_badges > 12
     * </code>
     *
     * @param     mixed $droitBadges The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByDroitBadges($droitBadges = null, $comparison = null)
    {
        if (is_array($droitBadges)) {
            $useMinMax = false;
            if (isset($droitBadges['min'])) {
                $this->addUsingAlias(AuthkeyPeer::DROIT_BADGES, $droitBadges['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($droitBadges['max'])) {
                $this->addUsingAlias(AuthkeyPeer::DROIT_BADGES, $droitBadges['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::DROIT_BADGES, $droitBadges, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AuthkeyPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AuthkeyPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AuthkeyPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AuthkeyPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthkeyPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Authkey $authkey Object to remove from the list of results
     *
     * @return AuthkeyQuery The current query, for fluid interface
     */
    public function prune($authkey = null)
    {
        if ($authkey) {
            $this->addUsingAlias(AuthkeyPeer::ID, $authkey->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AuthkeyPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AuthkeyPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AuthkeyPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AuthkeyPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AuthkeyPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     AuthkeyQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AuthkeyPeer::CREATED_AT);
    }
}
