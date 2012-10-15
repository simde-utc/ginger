<?php


/**
 * Base class that represents a query for the 'cotisation' table.
 *
 *
 *
 * @method CotisationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CotisationQuery orderByPersonneId($order = Criteria::ASC) Order by the personne_id column
 * @method CotisationQuery orderByDebut($order = Criteria::ASC) Order by the debut column
 * @method CotisationQuery orderByFin($order = Criteria::ASC) Order by the fin column
 * @method CotisationQuery orderByMontant($order = Criteria::ASC) Order by the montant column
 * @method CotisationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method CotisationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method CotisationQuery groupById() Group by the id column
 * @method CotisationQuery groupByPersonneId() Group by the personne_id column
 * @method CotisationQuery groupByDebut() Group by the debut column
 * @method CotisationQuery groupByFin() Group by the fin column
 * @method CotisationQuery groupByMontant() Group by the montant column
 * @method CotisationQuery groupByCreatedAt() Group by the created_at column
 * @method CotisationQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method CotisationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CotisationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CotisationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CotisationQuery leftJoinPersonne($relationAlias = null) Adds a LEFT JOIN clause to the query using the Personne relation
 * @method CotisationQuery rightJoinPersonne($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Personne relation
 * @method CotisationQuery innerJoinPersonne($relationAlias = null) Adds a INNER JOIN clause to the query using the Personne relation
 *
 * @method Cotisation findOne(PropelPDO $con = null) Return the first Cotisation matching the query
 * @method Cotisation findOneOrCreate(PropelPDO $con = null) Return the first Cotisation matching the query, or a new Cotisation object populated from the query conditions when no match is found
 *
 * @method Cotisation findOneById(int $id) Return the first Cotisation filtered by the id column
 * @method Cotisation findOneByPersonneId(int $personne_id) Return the first Cotisation filtered by the personne_id column
 * @method Cotisation findOneByDebut(string $debut) Return the first Cotisation filtered by the debut column
 * @method Cotisation findOneByFin(string $fin) Return the first Cotisation filtered by the fin column
 * @method Cotisation findOneByMontant(string $montant) Return the first Cotisation filtered by the montant column
 * @method Cotisation findOneByCreatedAt(string $created_at) Return the first Cotisation filtered by the created_at column
 * @method Cotisation findOneByUpdatedAt(string $updated_at) Return the first Cotisation filtered by the updated_at column
 *
 * @method array findById(int $id) Return Cotisation objects filtered by the id column
 * @method array findByPersonneId(int $personne_id) Return Cotisation objects filtered by the personne_id column
 * @method array findByDebut(string $debut) Return Cotisation objects filtered by the debut column
 * @method array findByFin(string $fin) Return Cotisation objects filtered by the fin column
 * @method array findByMontant(string $montant) Return Cotisation objects filtered by the montant column
 * @method array findByCreatedAt(string $created_at) Return Cotisation objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Cotisation objects filtered by the updated_at column
 *
 * @package    propel.generator.ginger.om
 */
abstract class BaseCotisationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCotisationQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ginger', $modelName = 'Cotisation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CotisationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     CotisationQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CotisationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CotisationQuery) {
            return $criteria;
        }
        $query = new CotisationQuery();
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
     * @return   Cotisation|Cotisation[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CotisationPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CotisationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @param     PropelPDO $con A connection object
     *
     * @return   Cotisation A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `PERSONNE_ID`, `DEBUT`, `FIN`, `MONTANT`, `CREATED_AT`, `UPDATED_AT` FROM `cotisation` WHERE `ID` = :p0';
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
            $obj = new Cotisation();
            $obj->hydrate($row);
            CotisationPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Cotisation|Cotisation[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Cotisation[]|mixed the list of results, formatted by the current formatter
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
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CotisationPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CotisationPeer::ID, $keys, Criteria::IN);
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
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(CotisationPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the personne_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonneId(1234); // WHERE personne_id = 1234
     * $query->filterByPersonneId(array(12, 34)); // WHERE personne_id IN (12, 34)
     * $query->filterByPersonneId(array('min' => 12)); // WHERE personne_id > 12
     * </code>
     *
     * @see       filterByPersonne()
     *
     * @param     mixed $personneId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByPersonneId($personneId = null, $comparison = null)
    {
        if (is_array($personneId)) {
            $useMinMax = false;
            if (isset($personneId['min'])) {
                $this->addUsingAlias(CotisationPeer::PERSONNE_ID, $personneId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personneId['max'])) {
                $this->addUsingAlias(CotisationPeer::PERSONNE_ID, $personneId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::PERSONNE_ID, $personneId, $comparison);
    }

    /**
     * Filter the query on the debut column
     *
     * Example usage:
     * <code>
     * $query->filterByDebut('2011-03-14'); // WHERE debut = '2011-03-14'
     * $query->filterByDebut('now'); // WHERE debut = '2011-03-14'
     * $query->filterByDebut(array('max' => 'yesterday')); // WHERE debut > '2011-03-13'
     * </code>
     *
     * @param     mixed $debut The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByDebut($debut = null, $comparison = null)
    {
        if (is_array($debut)) {
            $useMinMax = false;
            if (isset($debut['min'])) {
                $this->addUsingAlias(CotisationPeer::DEBUT, $debut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($debut['max'])) {
                $this->addUsingAlias(CotisationPeer::DEBUT, $debut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::DEBUT, $debut, $comparison);
    }

    /**
     * Filter the query on the fin column
     *
     * Example usage:
     * <code>
     * $query->filterByFin('2011-03-14'); // WHERE fin = '2011-03-14'
     * $query->filterByFin('now'); // WHERE fin = '2011-03-14'
     * $query->filterByFin(array('max' => 'yesterday')); // WHERE fin > '2011-03-13'
     * </code>
     *
     * @param     mixed $fin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByFin($fin = null, $comparison = null)
    {
        if (is_array($fin)) {
            $useMinMax = false;
            if (isset($fin['min'])) {
                $this->addUsingAlias(CotisationPeer::FIN, $fin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fin['max'])) {
                $this->addUsingAlias(CotisationPeer::FIN, $fin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::FIN, $fin, $comparison);
    }

    /**
     * Filter the query on the montant column
     *
     * Example usage:
     * <code>
     * $query->filterByMontant(1234); // WHERE montant = 1234
     * $query->filterByMontant(array(12, 34)); // WHERE montant IN (12, 34)
     * $query->filterByMontant(array('min' => 12)); // WHERE montant > 12
     * </code>
     *
     * @param     mixed $montant The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByMontant($montant = null, $comparison = null)
    {
        if (is_array($montant)) {
            $useMinMax = false;
            if (isset($montant['min'])) {
                $this->addUsingAlias(CotisationPeer::MONTANT, $montant['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($montant['max'])) {
                $this->addUsingAlias(CotisationPeer::MONTANT, $montant['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::MONTANT, $montant, $comparison);
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
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CotisationPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CotisationPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return CotisationQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CotisationPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CotisationPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CotisationPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related Personne object
     *
     * @param   Personne|PropelObjectCollection $personne The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   CotisationQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByPersonne($personne, $comparison = null)
    {
        if ($personne instanceof Personne) {
            return $this
                ->addUsingAlias(CotisationPeer::PERSONNE_ID, $personne->getId(), $comparison);
        } elseif ($personne instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CotisationPeer::PERSONNE_ID, $personne->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPersonne() only accepts arguments of type Personne or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Personne relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function joinPersonne($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Personne');

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
            $this->addJoinObject($join, 'Personne');
        }

        return $this;
    }

    /**
     * Use the Personne relation Personne object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PersonneQuery A secondary query class using the current class as primary query
     */
    public function usePersonneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPersonne($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Personne', 'PersonneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Cotisation $cotisation Object to remove from the list of results
     *
     * @return CotisationQuery The current query, for fluid interface
     */
    public function prune($cotisation = null)
    {
        if ($cotisation) {
            $this->addUsingAlias(CotisationPeer::ID, $cotisation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CotisationPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CotisationPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CotisationPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CotisationPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CotisationPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     CotisationQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CotisationPeer::CREATED_AT);
    }
}
