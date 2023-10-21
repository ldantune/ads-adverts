<?php

namespace App\Models;

use App\Entities\Advert;
use CodeIgniter\Model;

class AdvertModel extends MyBaseModel
{
    private $user;

    public function __construct()
    {

        parent::__construct();

        $this->user = service('auth')->user() ?? auth('api')->user();
    }

    protected $DBGroup          = 'default';
    protected $table            = 'adverts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = Advert::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'category_id',
        'code',
        'title',
        'description',
        'price',
        //'is_published', // esse não colocamos aqui, pois queremos ter um controle maior de quando o anúncio deverá ser publicado/despublicado
        'situation',
        'zipcode',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeDataXSS', 'generateCitySlug', 'generateCode', 'setUserID'];
    protected $beforeUpdate   = ['escapeDataXSS', 'generateCitySlug', 'unpublish'];

    protected function generateCitySlug(array $data): array
    {
        if (isset($data['data']['city'])) {

            $data['data']['city_slug'] = mb_url_title($data['data']['city'], lowercase: true);
        }

        return $data;
    }

    protected function generateCode(array $data): array
    {
        if (isset($data['data'])) {

            $data['data']['code'] = strtoupper(uniqid('AVERT_', true));
        }

        return $data;
    }

    protected function setUserID(array $data): array
    {
        if (isset($data['data'])) {

            $data['data']['user_id'] = $this->user->id;
        }

        return $data;
    }


    protected function unpublish(array $data): array
    {
        // Houve alteração no title ou description?
        if (isset($data['data']['title']) || isset($data['data']['description'])) {

            // Sim.... houve alteração.... então tornamos o anúncio como não publicado (false)
            $data['data']['is_published'] = false;
        }

        return $data;
    }

    /**
     * Recupera todos os anúncios de acordo com o usuário logado.
     *
     * @param boolean $onlyDeleted
     * @return array
     */
    public function getAllAdverts(bool $onlyDeleted = false)
    {
        $this->setSQLMode();

        $builder = $this;

        if ($onlyDeleted) {

            $builder->onlyDeleted();
        }


        $tableFields = [
            'adverts.*',
            'categories.name AS category',
            'adverts_images.image AS images', // apelido (alias) de 'images', que utilizaremos no método image() do Entity Advert
        ];

        $builder->select($tableFields);


        // Quem está logado é o manager?
        if (!$this->user->isSuperadmin()) {

            // É o usuário anunciante.... então recuperamos apenas os anúncios dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->join('adverts_images', 'adverts_images.advert_id = adverts.id', 'LEFT'); // Nem todos os anúncios terão imagens
        $builder->groupBy('adverts.id'); // para não repetir registros
        $builder->orderBy('adverts.id', 'DESC');

        return $builder->findAll();
    }


    /**
     * Recupera o anúncio de acordo com o id.
     *
     * @param integer $id
     * @param boolean $withDeleted
     * @return object|null
     */
    public function getAdvertByID(int $id, bool $withDeleted = false)
    {

        $builder = $this;

        $tableFields = [
            'adverts.*',
            'users.email', // para notificarmos o usuário/anunciante
        ];

        $builder->select($tableFields);
        $builder->withDeleted($withDeleted);

        // Quem está logado é o manager?
        if (!$this->user->isSuperadmin()) {

            // É o usuário anunciante.... então recuperamos apenas os anúncios dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        $builder->join('users', 'users.id = adverts.user_id');

        $advert = $builder->find($id);

        // Foi encontrado um anúncio?
        if (!is_null($advert)) {

            // Sim... então podemos buscar as imagens do mesmo
            $advert->images = $this->getAdvertImages($advert->id);
        }

        // Retornamos o anúncio que pode ou não ter imagens
        return $advert;
    }


    public function getAdvertImages(int $advertID): array
    {
        return $this->db->table('adverts_images')->where('advert_id', $advertID)->get()->getResult();
    }


    public function trySaveAdvert(Advert $advert, bool $protect = true)
    {
        try {

            $this->db->transStart();

            $this->protect($protect)->save($advert);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error saving data');
        }
    }


    public function tryStoreAdvertImages(array $dataImages, int $advertID)
    {
        try {

            $this->db->transStart();

            $this->db->table('adverts_images')->insertBatch($dataImages);

            $this->protect(false)->set('is_published', false)->where('id', $advertID)->update();

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error saving data');
        }
    }


    public function tryDeleteAdvertImage(int $advertID, string $image)
    {
        $criteria = [
            'advert_id' => $advertID,
            'image'     => $image
        ];

        return $this->db->table('adverts_images')->where($criteria)->delete();
    }


    public function tryArchiveAdvert(int $advertID)
    {
        try {

            $this->db->transStart();

            // Quem está logado é o manager?
            if (!$this->user->isSuperadmin()) {

                // É o usuário anunciante.... então arquivamos apenas os anúncio dele

                $this->where('user_id', $this->user->id)->delete($advertID);
            } else {

                // é o manager
                $this->delete($advertID);
            }

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error saving data');
        }
    }

    public function tryDeleteAdvert(int $advertID)
    {
        try {

            $this->db->transStart();

            // Quem está logado é o manager?
            if (!$this->user->isSuperadmin()) {

                // É o usuário anunciante.... então recuperamos apenas os anúncios dele

                $this->where('user_id', $this->user->id)->delete($advertID, true);
            } else {

                // É o manager...
                $this->delete($advertID, true);
            }

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error deleting data');
        }
    }


    public function getAllAdvertsPaginated(int $perPage = 10, array $criteria = [])
    {
        $this->setSQLMode();

        $builder = $this;

        $tableFields = [
            'adverts.*',
            'categories.name AS category',
            'categories.slug AS category_slug',
            'adverts_images.image AS images', // para utilizarmos no método image do entity advert
        ];

        $builder->select($tableFields);
        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->join('adverts_images', 'adverts_images.advert_id = adverts.id');

        if (!empty($criteria)) {

            $builder->where($criteria);
        }

        $builder->where('adverts.is_published', true);
        $builder->orderBy('adverts.id', 'DESC');
        $builder->groupBy('adverts.id');

        $adverts = $builder->paginate($perPage);

        return $adverts;
    }


    public function getAdvertByCode(string $code, bool $ofTheLoggedInUser = false)
    {
        $tableFields = [
            'adverts.*',
            'users.name',
            'users.email', // usaremos para a parte de perguntas
            'users.username',
            'users.phone',
            'users.display_phone',
            'users.created_at AS user_since',
            'categories.name AS category',
            'categories.slug AS category_slug', // usaremos para filtrar os anúncios por categoria
        ];

        $builder = $this;
        $builder->select($tableFields);
        $builder->join('users', 'users.id = adverts.user_id');
        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->where('adverts.is_published', true);
        $builder->where('adverts.code', $code);

        if ($ofTheLoggedInUser) {

            $builder->where('adverts.user_id', $this->user->id);
        }

        $advert = $builder->first();


        if (!is_null($advert)) {

            // recupero as imagens do mesmo
            $advert->images = $this->getAdvertImages($advert->id);
        }


        if (!is_null($advert)) {

            // recupero as perguntas e respostas do mesmo
            $advert->questions = $this->getAdvertQuestions($advert->id);
        }

        return $advert;
    }


    public function getCitiesFromPublishedAdverts(int $limit = 5, string $categorySlug = null): array
    {
        $this->setSQLMode();

        $tableFields = [
            'adverts.*',
            'categories.name AS category', // para debug
            'COUNT(adverts.id) AS total_adverts'
        ];

        // recupero apenas os adverts_id da tabela de imagens
        $advertsIDS = array_column($this->db->table('adverts_images')->select('advert_id')->get()->getResultArray(), 'advert_id');

        $builder = $this;

        $builder->select($tableFields);
        //$builder->asArray(); // para debug
        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->where('adverts.is_published', true);
        $builder->where('categories.slug', $categorySlug);
        $builder->whereIn('adverts.id', $advertsIDS); // apenas em anúncios que possuem imagem
        $builder->groupBy('adverts.city');
        $builder->orderBy('total_adverts', 'DESC');

        return $builder->findAll($limit);
    }

    public function countAllUserAdverts(int $userID, bool $withDeleted = true, array $criteria = []): int
    {
        $builder = $this;

        if (!empty($criteria)) {

            $builder->where($criteria);
        }

        $builder->where('adverts.user_id', $userID);
        $builder->withDeleted($withDeleted);

        return $builder->countAllResults();
    }

    //------------------------ Perguntas e respostas ----------------------------///

    public function getAdvertQuestions(int $advertID): array
    {
        $builder = $this->db->table('adverts_questions');
        $builder->where('advert_id', $advertID);
        $builder->orderBy('id', 'DESC');
        return $builder->get()->getResult();
    }

    public function insertAdvertQuestion(int $advertID, string $question)
    {
        try {

            $this->db->transStart();

            $data = [
                'advert_id'         => $advertID,
                'user_question_id'  => $this->user->id,
                'question'          => esc($question),
                'created_at'        => date('Y-m-d H:i:s'),
            ];

            $this->db->table('adverts_questions')->insert($data);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao realizar a pergunta');
        }
    }

    public function answerAdvertQuestion(int $questionID, int $advertID, string $answer)
    {
        try {

            $this->db->transStart();

            $criteria = [
                'id'        => $questionID,
                'advert_id' => $advertID,
            ];

            $data = [
                'answer'      => esc($answer),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $this->db->table('adverts_questions')->where($criteria)->update($data);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro na resposta da pergunta');
        }
    }

    //------------------------ Pesquisa por autocomplete ----------------------------///

    public function getAllAdvertsByTerm(string $term = null): array
    {
        $this->setSQLMode();

        $builder = $this;

        $tableFields = [
            'adverts.id',
            'adverts.code',
            'adverts.title',
            'adverts_images.image AS images',
        ];

        $builder->select($tableFields);
        $builder->join('adverts_images', 'adverts_images.advert_id = adverts.id', 'LEFT'); // Nem todos os anúncios terão imagens
        $builder->groupBy('adverts.id'); // para não repetir registros
        $builder->orderBy('adverts.id', 'DESC');
        $builder->where('is_published', true); // apenas anúncios publicados
        $builder->like('title', $term, 'both');

        return $builder->findAll();
    }

    //------------------------ API ----------------------------///

    public function getAllAdvertsForUserAPI(int $perPage = null, int $page = null)
    {
        $this->setSQLMode();

        $builder = $this;


        $tableFields = [
            'adverts.*',
            'categories.name AS category',
            'categories.slug AS category_slug',
            'users.username' // quem é o dono dos anúncios
        ];

        $builder->select($tableFields);

        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->join('users', 'users.id = adverts.user_id');
        $builder->where('adverts.user_id', $this->user->id);
        $builder->groupBy('adverts.id'); // para não repetir registros
        $builder->orderBy('adverts.id', 'DESC');

        $adverts = $this->paginate(perPage: $perPage, page: $page);

        if (!empty($adverts)) {

            foreach ($adverts as $advert) {

                $advert->images = $this->getAdvertImages($advert->id);
            }
        }

        return $adverts;
    }
}
