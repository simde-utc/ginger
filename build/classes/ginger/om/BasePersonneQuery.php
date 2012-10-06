<?php


/**
 * Base class that represents a query for the 'personne' table.
 *
 *
 *
 * @method PersonneQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PersonneQuery orderByLogin($order = Criteria::ASC) Order by the login column
 * @method PersonneQuery orderByPrenom($order = Criteria::ASC) Order by the prenom column
 * @method PersonneQuery orderByNom($order = Criteria::ASC) Order by the nom column
 * @method PersonneQuery orderByMail($order = Criteria::ASC) Order by the mail column
 * @method PersonneQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method PersonneQuery orderByDateNaissance($order = Criteria::ASC) Order by the date_naissance column
 * @method PersonneQuery orderByIsAdulte($order = Criteria::ASC) Order by the is_adulte column
 * @method PersonneQuery orderByBadgeUid($order = Criteria::ASC) Order by the badge_uid column
 * @method PersonneQuery orderByExpirationBadge($order = Criteria::ASC) Order by the expiration_badge column
 * @method PersonneQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method PersonneQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method PersonneQuery groupById() Group by the id column
 * @method PersonneQuery groupByLogin() Group by the login column
 * @method PersonneQuery groupByPrenom() Group by the prenom column
 * @method PersonneQuery groupByNom() Group by the nom column
 * @method PersonneQuery groupByMail() Group by the mail column
 * @method PersonneQuery groupByType() Group by the type column
 * @method PersonneQuery groupByDateNaissance() Group by the date_naissance column
 * @method PersonneQuery groupByIsAdulte() Group by the is_adulte column
 * @method PersonneQuery groupByBadgeUid() Group by the badge_uid column
 * @method PersonneQuery groupByExpirationBadge() Group by the expiration_badge column
 * @method PersonneQuery groupByCreatedAt() Group by the created_at column
 * @method PersonneQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method PersonneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PersonneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PersonneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PersonneQuery leftJoinCotisation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cotisation relation
 * @method PersonneQuery rightJoinCotisation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cotisation relation
 * @method PersonneQuery innerJoinCotisation($relationAlias = null) Adds a INNER JOIN clause to the query using the Cotisation relation
 *
 * @method Personne findOne(PropelPDO $con = null) Return the first Personne matching the query
 * @method Personne findOneOrCreate(PropelPDO $con = null) Return the first Personne matching the query, or a new Personne object populated from the query conditions when no match is found
 *
 * @method Personne findOneByLogin(string $login) Return the first Personne filtered by the login column
 * @method Personne findOneByPrenom(string $prenom) Return the first Personne filtered by the prenom column
 * @method Personne findOneByNom(string $nom) Return the first Personne filtered by the nom column
 * @method Personne findOneByMail(string $mail) Return the first Personne filtered by the mail column
 * @method Personne findOneByType(int $type) Return the first Personne filtered by the type column
 * @method Personne findOneByDateNaissance(string $date_naissance) Return the first Personne filtered by the date_naissance column
 * @method Personne findOneByIsAdulte(boolean $is_adulte) Return the first Personne filtered by the is_adulte column
 * @method Personne findOneByBadgeUid(string $badge_uid) Return the first Personne filtered by the badge_uid column
 * @method Personne findOneByExpirationBadge(string $expiration_badge) Return the first Personne filtered by the expiration_badge column
 * @method Personne findOneByCreatedAt(string $created_at) Return the first Personne filtered by the created_at column
 * @method Personne findOneByUpdatedAt(string $updated_at) Return the first Personne filtered by the updated_at column
 *
 * @method array findById(int $id) Return Personne objects filtered by the id column
 * @method array findByLogin(string $login) Return Personne objects filtered by the login column
 * @method array findByPrenom(string $prenom) Return Personne objects filtered by the prenom column
 * @method array findByNom(string $nom) Return Personne objects filtered by the nom column
 * @method array findByMail(string $mail) Return Personne objects filtered by the mail column
 * @method array findByType(int $type) Return Personne objects filtered by the type column
 * @method array findByDateNaissance(string $date_naissance) Return Personne objects filtered by the date_naissance column
 * @method array findByIsAdulte(boolean $is_adulte) Return Personne objects filtered by the is_adulte column
 * @method array findByBadgeUid(string $badge_uid) Return Personne objects filtered by the badge_uid column
 * @method array findByExpirationBadge(string $expiration_badge) Return Personne objects filtered by the expiration_badge column
 * @method array findByCreatedAt(string $created_at) Return Personne objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Personne objects filtered by the updated_at column
 *
 * @package    propel.generator.ginger.om
 */
abstract class BasePersonneQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePersonneQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ginger', $modelName = 'Personne', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PersonneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     PersonneQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PersonneQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PersonneQuery) {
            return $criteria;
        }
        $query = new PersonneQuery();
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
     * @return   Personne|Personne[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PersonnePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PersonnePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Personne A model object, or null if the key is not found
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
     * @return   Personne A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `LOGIN`, `PRENOM`, `NOM`, `MAIL`, `TYPE`, `DATE_NAISSANCE`, `IS_ADULTE`, `BADGE_UID`, `EXPIRATION_BADGE`, `CREATED_AT`, `UPDATED_AT` FROM `personne` WHERE `ID` = :p0';
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
            $obj = new Personne();
            $obj->hydrate($row);
            PersonnePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Personne|Personne[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Personne[]|mixed the list of results, formatted by the current formatter
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
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PersonnePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PersonnePeer::ID, $keys, Criteria::IN);
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
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(PersonnePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the login column
     *
     * Example usage:
     * <code>
     * $query->filterByLogin('fooValue');   // WHERE login = 'fooValue'
     * $query->filterByLogin('%fooValue%'); // WHERE login LIKE '%fooValue%'
     * </code>
     *
     * @param     string $login The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByLogin($login = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($login)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $login)) {
                $login = str_replace('*', '%', $login);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonnePeer::LOGIN, $login, $comparison);
    }

    /**
     * Filter the query on the prenom column
     *
     * Example usage:
     * <code>
     * $query->filterByPrenom('fooValue');   // WHERE prenom = 'fooValue'
     * $query->filterByPrenom('%fooValue%'); // WHERE prenom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prenom The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByPrenom($prenom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prenom)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prenom)) {
                $prenom = str_replace('*', '%', $prenom);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonnePeer::PRENOM, $prenom, $comparison);
    }

    /**
     * Filter the query on the nom column
     *
     * Example usage:
     * <code>
     * $query->filterByNom('fooValue');   // WHERE nom = 'fooValue'
     * $query->filterByNom('%fooValue%'); // WHERE nom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nom The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByNom($nom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nom)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nom)) {
                $nom = str_replace('*', '%', $nom);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonnePeer::NOM, $nom, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterByMail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterByMail('%fooValue%'); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByMail($mail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mail)) {
                $mail = str_replace('*', '%', $mail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonnePeer::MAIL, $mail, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        $valueSet = PersonnePeer::getValueSet(PersonnePeer::TYPE);
        if (is_scalar($type)) {
            if (!in_array($type, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $type));
            }
            $type = array_search($type, $valueSet);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonnePeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the date_naissance column
     *
     * Example usage:
     * <code>
     * $query->filterByDateNaissance('2011-03-14'); // WHERE date_naissance = '2011-03-14'
     * $query->filterByDateNaissance('now'); // WHERE date_naissance = '2011-03-14'
     * $query->filterByDateNaissance(array('max' => 'yesterday')); // WHERE date_naissance > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateNaissance The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByDateNaissance($dateNaissance = null, $comparison = null)
    {
        if (is_array($dateNaissance)) {
            $useMinMax = false;
            if (isset($dateNaissance['min'])) {
                $this->addUsingAlias(PersonnePeer::DATE_NAISSANCE, $dateNaissance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateNaissance['max'])) {
                $this->addUsingAlias(PersonnePeer::DATE_NAISSANCE, $dateNaissance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonnePeer::DATE_NAISSANCE, $dateNaissance, $comparison);
    }

    /**
     * Filter the query on the is_adulte column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAdulte(true); // WHERE is_adulte = true
     * $query->filterByIsAdulte('yes'); // WHERE is_adulte = true
     * </code>
     *
     * @param     boolean|string $isAdulte The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByIsAdulte($isAdulte = null, $comparison = null)
    {
        if (is_string($isAdulte)) {
            $is_adulte = in_array(strtolower($isAdulte), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PersonnePeer::IS_ADULTE, $isAdulte, $comparison);
    }

    /**
     * Filter the query on the badge_uid column
     *
     * Example usage:
     * <code>
     * $query->filterByBadgeUid('fooValue');   // WHERE badge_uid = 'fooValue'
     * $query->filterByBadgeUid('%fooValue%'); // WHERE badge_uid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $badgeUid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByBadgeUid($badgeUid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($badgeUid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $badgeUid)) {
                $badgeUid = str_replace('*', '%', $badgeUid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonnePeer::BADGE_UID, $badgeUid, $comparison);
    }

    /**
     * Filter the query on the expiration_badge column
     *
     * Example usage:
     * <code>
     * $query->filterByExpirationBadge('2011-03-14'); // WHERE expiration_badge = '2011-03-14'
     * $query->filterByExpirationBadge('now'); // WHERE expiration_badge = '2011-03-14'
     * $query->filterByExpirationBadge(array('max' => 'yesterday')); // WHERE expiration_badge > '2011-03-13'
     * </code>
     *
     * @param     mixed $expirationBadge The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByExpirationBadge($expirationBadge = null, $comparison = null)
    {
        if (is_array($expirationBadge)) {
            $useMinMax = false;
            if (isset($expirationBadge['min'])) {
                $this->addUsingAlias(PersonnePeer::EXPIRATION_BADGE, $expirationBadge['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expirationBadge['max'])) {
                $this->addUsingAlias(PersonnePeer::EXPIRATION_BADGE, $expirationBadge['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonnePeer::EXPIRATION_BADGE, $expirationBadge, $comparison);
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
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PersonnePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PersonnePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonnePeer::CREATED_AT, $createdAt, $comparison);
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
     * @return PersonneQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PersonnePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PersonnePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonnePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related Cotisation object
     *
     * @param   Cotisation|PropelObjectCollection $cotisation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   PersonneQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByCotisation($cotisation, $comparison = null)
    {
        if ($cotisation instanceof Cotisation) {
            return $this
                ->addUsingAlias(PersonnePeer::ID, $cotisation->getPersonneId(), $comparison);
        } elseif ($cotisation instanceof PropelObjectCollection) {
            return $this
                ->useCotisationQuery()
                ->filterByPrimaryKeys($cotisation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCotisation() only accepts arguments of type Cotisation or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cotisation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function joinCotisation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cotisation');

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
            $this->addJoinObject($join, 'Cotisation');
        }

        return $this;
    }

    /**
     * Use the Cotisation relation Cotisation object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   CotisationQuery A secondary query class using the current class as primary query
     */
    public function useCotisationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCotisation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cotisation', 'CotisationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Personne $personne Object to remove from the list of results
     *
     * @return PersonneQuery The current query, for fluid interface
     */
    public function prune($personne = null)
    {
        if ($personne) {
            $this->addUsingAlias(PersonnePeer::ID, $personne->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PersonnePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PersonnePeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PersonnePeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PersonnePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PersonnePeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     PersonneQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PersonnePeer::CREATED_AT);
    }
}
