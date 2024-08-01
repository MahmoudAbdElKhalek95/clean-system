<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "targets";
    public const TYPE_ID = 1;
    public const TYPE_CODE = 2;
    protected $fillable = [
        'day',
        'target',
        'section_id',
        'project_id',
        'achieved',
        'type',
        'date_type',
        'date_from',
        'date_to',
        'archive_id',
        'show_in_statistics'
    ];

    public function section(): ?BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function archive(): ?BelongsTo
    {
        return $this->belongsTo(Archive::class, 'archive_id');
    }

    public function path(): ?BelongsTo
    {
        return $this->belongsTo(Path::class, 'section_id');
    }

    public function project(): ?BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function targetproject(): ?BelongsTo
    {
        return $this->belongsTo(Project::class, 'section_id');
    }
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(Project::class, 'section_id');
    }

    public function category(): ?BelongsTo
    {
        return $this->belongsTo(Category::class, 'section_id');
    }

    public function initiative(): ?BelongsTo
    {
        return $this->belongsTo(Initiative::class, 'section_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'target_users');
    }

    public function all_targets()
    {

        $today  =  date('Y-m-d') ;

        $target = self::where('day', '<=', $today)->sum('target')  ;

        return   $target  ;

    }

    public function totalTargets($section_id, $type)
    {
        return self::where('section_id', $section_id)->where('type', $type)->sum('target');
    }


    public function getNmae($type)
    {

        if ($type == 1) {
            return $this->initiative ? $this->initiative->name : '';
        }
        if ($type == 2) {
            return $this->path ? $this->path->name : '';
        }
        if ($type == 3) {
            return $this->user ? $this->user->name : '';
        }
        if ($type == 4) {
            return $this->targetproject ? $this->targetproject->name : '';
        }
        if ($type == 5) {
            return $this->category ? $this->category->name : '';
        }
        return $this->initiative ? $this->initiative->name : '';
    }

    public function total_achieved($type,$archive_id=null)
    {

        if($archive_id==null){
            $archive=Archive::where('status', 1)->first();
            if($archive) {
                $archive_id=$archive->id;
            } else {
                $archive_id=0;
            }
        }
        if($type==1) {
            if($this->initiative) {
                if($this->initiative->type==1) {
                    return Link::where('archive_id',$archive_id)->where('section_code', $this->initiative->code)
                        ->sum('total');
                }
                if($this->initiative->type==2) {
                    $project_codes=Project::where('category_id', $this->initiative->category_id)->pluck('code');
                    return Link::where('archive_id',$archive_id)->whereIn('project_number', $project_codes)->sum('total');
                }
                if($this->initiative->type==3) {
                    if($this->initiative->project) {
                        return Link::where('archive_id',$archive_id)->where('project_number', $this->initiative->project_id)
                            ->sum('total');
                    }
                }
                return Link::where('archive_id',$archive_id)->where('section_code', $this->initiative->code)
                ->sum(DB::raw('total'));
            }
        } elseif($type==2) {
            $section_code= Initiative::where('path_id', $this->section_id)->pluck('code')->toArray();
            return Link::where('archive_id',$archive_id)->whereIn('section_code', $section_code)
            ->sum(DB::raw('total'));
        } elseif($type==3) {
            return Link::where('archive_id',$archive_id)->where('user_id', $this->section_id)
            ->sum(DB::raw('total'));

        } elseif($type==4) {
            if($this->project) {
                return Link::where('archive_id',$archive_id)->where('project_number', $this->project->code)
                ->sum(DB::raw('total'));
            }
        } elseif($type==5) {
            if($this->category) {
                return Link::where('archive_id',$archive_id)->where('category_id', $this->category->category_number)
                ->sum(DB::raw('total'));
            }
        }
        return 0;


    }



}
