<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Api\PublicationRepository;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
use App\Models\Vendor\Block;

/**
 * MigrationDB 
 * 
 * Wrapper around the migration db -- basically just an open()-er?
 * 
 * TODO: construct() should take a migration filename string
 */
class MigrationDB extends \SQLite3 {

    function __construct()
    {
        $this->open('migration.sqlite3');
    }

}

class MigrateOSCIPublicationOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:osci-publication {id : Publication ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate an OSCI publication from a migration file to a website DigitalPublication';

    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     * 
     * TODO: This should take.. a migration filename?
     */
    public function __construct()
    {
        $this->db = new MigrationDB();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pubId = $this->argument('id');

        // NB!: For each of these types in the admin UI it's impossible to validate the save without setting a date!

        $pubQuery = $this->db->prepare("SELECT json_extract(publications.data,'$._title') as title FROM publications LEFT JOIN tocs ON tocs.package=publications.pub_id WHERE pub_id=:id");
        $pubQuery->bindValue(':id',$pubId);

        $result = $pubQuery->execute();
        $pub = $result->fetchArray();

        // TODO: Handle italics / etc in the title
        // TODO: Set any other publication level metadata (date?)

        $webPub = new DigitalPublication();
        $webPub->title = 'Migrated ' . date('M j, Y') . ' | ' . $pub["title"];
        $webPub->published = false;
        $webPub->is_dsc_stub = false;
        $webPub->save();

        $webPubId = $webPub->id;

        $textsQuery = $this->db->prepare("SELECT coalesce(json_extract(data,'$._title'),'FIXME') as title,text_id FROM texts WHERE package=:pubId and text_id NOT LIKE '%ncxtoc%'");
        $textsQuery->bindValue(':pubId',$pubId);

        $textResult = $textsQuery->execute();
        $text = $textResult->fetchArray();

        while ($text) {
            
            $webArticle = new DigitalPublicationArticle();
            $webArticle->type = "text";
            $webArticle->title = $text['title'];
            $webArticle->published = false;
            $webArticle->digital_publication_id = $webPubId;
            $webArticle->date = date('M j, Y');
            $webArticle->updated_at = date('M j, Y');
            $webArticle->created_at = date('M j, Y');

            // TODO: Join toc position via json_tree against toc data
            $webArticle->position = 0; 

            $webArticle->save();

            // TODO: Use a multiline string!! Also this can be moved outside the while

            $blocksQuery = $this->db->prepare("SELECT json_extract(blk.value,'$.html') as html, blk.id as position, json_extract(blk.value,'$.blockType') as type, json_extract(blk.value,'$.fallback_url') as figure_url, coalesce(json_extract(blk.value,'$.caption_html'),'') as figure_capt from texts, json_each(texts.data,'$.sections') as sects,json_each(sects.value,'$.blocks') as blk where texts.text_id=:textId");

            $blocksQuery->bindValue(':textId',$text['text_id']);

            $blocksResult = $blocksQuery->execute();

            $blk = $blocksResult->fetchArray();

            $order = 0;

            while ($blk) {

                $block = new Block();
                $block->blockable_id = $webArticle->id;
                $block->blockable_type = 'App\Models\DigitalPublicationArticle';

                $block->position = $order;

                // TODO: Adapt Trevin's spec image code here
                if ($blk['type'] == 'figure') {
                    
                    // $figText = '<span>'.$blk['figure_url'].'</span>';
                    $figText = '<figure><img src="'. $blk['figure_url'] . '" alt /><figcaption>'.$blk['figure_capt'].'</figcaption></figure>';

                    $block->content = [ 'paragraph' => $figText ];
                } else {
                    $block->content = [ 'paragraph' => $blk['html'] ];
                }

                $block->type = 'paragraph';
                $block->save();

                $webArticle->blocks()->save($block);

                $blk = $blocksResult->fetchArray();
                $order += 1;
            }

            $webArticle->save();
            $webPub->articles()->save($webArticle);

            $text = $textResult->fetchArray();

        }
    
        $webPub->save();
    }
}
