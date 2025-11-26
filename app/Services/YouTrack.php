<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class YouTrack
{
    private Factory|PendingRequest|null $client = null;

    protected function getClient(): Factory|PendingRequest|null
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.youtrack.token'),
        ])->baseUrl(config('services.youtrack.base_uri'));

        return $this->client;
    }

    /**
     * @throws ConnectionException
     */
    public function getProjectId(string $shortName)
    {
        $result = $this
            ->getClient()
            ->get('admin/projects?fields=id&query='.$shortName);

        return $result->json('0.id');
    }

    public function getTagId(string $tagName): ?string
    {
        $result = $this
            ->getClient()
            ->get('tags?fields=id&query='.$tagName);

        return $result->json('0.id');
    }

    public function tagIssue(string $issueId, string $tagId)
    {
        $result = $this
            ->getClient()
            ->post('issues/'.$issueId.'/tags?fields=id,name', [
                'id' => $tagId,
            ]);

        return $result->json();
    }

    /**
     * @throws ConnectionException
     */
    public function createIssue(string $summary, string $description)
    {
        $projectId = $this->getProjectId(config('services.youtrack.project_shortname'));

        $issueResult = $this
            ->getClient()
            ->post('issues', [
                'project' => ['id' => $projectId],
                'summary' => $summary,
                'description' => $description,
            ]);

        if (config('services.youtrack.issue_tag')) {
            $tagId = $this->getTagId(config('services.youtrack.issue_tag'));
            $this->tagIssue($issueResult->json('id'), $tagId);
        }

        return $issueResult->json('id');
    }
}
