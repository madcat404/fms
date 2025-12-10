<?php
                                                // 조회할 채널 목록을 배열로 관리합니다.
                                                $channelTitles = [
                                                    '김한용의 MOCAR',
                                                    '더드라이브 TheDriveKorea',
                                                    '남자들의 자동차 - 남차카페',
                                                    '신차열전',
                                                    'Motorian모터리언'
                                                ];

                                                foreach ($channelTitles as $channelTitle) {
                                                    $Data_Channelinfo = null; // 채널 정보 초기화
                                                    $Result_PLAYCOUNT = null; // 비디오 결과 초기화

                                                    try {
                                                        // 채널 정보 조회
                                                        $Query_Channelinfo = "SELECT * FROM YOUTUBE_CHANNEL WHERE channelTitle = ?";
                                                        // mysqli는 prepare/bind_param/execute 방식으로 쿼리 실행을 권장합니다.
                                                        // 여기서는 간결성을 위해 $connect4->query()를 사용하지만, 실제 프로덕션에서는
                                                        // 준비된 구문을 사용하는 것이 SQL 인젝션 방지에 훨씬 더 안전합니다.
                                                        // (만약 $channelTitle이 사용자 입력으로 올 가능성이 있다면 더더욱 중요합니다.)
                                                        $stmt_channel = $connect4->prepare($Query_Channelinfo);
                                                        $stmt_channel->bind_param("s", $channelTitle);
                                                        $stmt_channel->execute();
                                                        $Result_Channelinfo = $stmt_channel->get_result();
                                                        
                                                        if ($Result_Channelinfo && $Result_Channelinfo->num_rows > 0) {
                                                            $Data_Channelinfo = $Result_Channelinfo->fetch_assoc();
                                                        } else {
                                                            // 채널 정보가 없는 경우 스킵
                                                            continue; 
                                                        }

                                                        // 비디오 목록 조회 (최신 12개)
                                                        $Query_PLAYCOUNT = "SELECT * FROM PLAYITEM WHERE channelTitle = ? AND use_yn = 'Y' ORDER BY publishedAt DESC LIMIT 12";
                                                        $stmt_videos = $connect4->prepare($Query_PLAYCOUNT);
                                                        $stmt_videos->bind_param("s", $channelTitle);
                                                        $stmt_videos->execute();
                                                        $Result_PLAYCOUNT = $stmt_videos->get_result();
                                                        
                                                        // 고유한 collapse ID를 생성합니다 (예: collapseCardExample91t -> collapseCardExample_김한용의_MOCAR_t)
                                                        $collapseId = 'collapseCardExample_' . preg_replace('/[^a-zA-Z0-9]/', '_', $channelTitle) . '_t';

                                            ?>
                                                        <div class="row">
                                                            <div class="col-12 ">
                                                                <div class="card shadow mb-2">
                                                                    <a href="#<?php echo htmlspecialchars($collapseId); ?>" class="d-block card-header py-3" data-toggle="collapse"
                                                                        role="button" aria-expanded="true" aria-controls="<?php echo htmlspecialchars($collapseId); ?>">
                                                                        <div class="row">
                                                                            <img src="<?php echo htmlspecialchars($Data_Channelinfo['MAKER_PIC']); ?>" style="width: 30px; height: 30px;">
                                                                            <h1 class="h6 m-1 font-weight-bold text-primary"><?php echo htmlspecialchars($channelTitle); ?></h1>
                                                                        </div>
                                                                    </a>
                                                                    <div class="row">
                                                                        <?php
                                                                        if ($Result_PLAYCOUNT && $Result_PLAYCOUNT->num_rows > 0) {
                                                                            // mysqli_fetch_array 대신 fetch_assoc()를 사용하여 연관 배열로 가져오는 것이 일반적입니다.
                                                                            while ($Data_SubTitle = $Result_PLAYCOUNT->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="col-12 col-sx-3 col-lg-4 col-md-6 col-sm-12 collapse" id="<?php echo htmlspecialchars($collapseId); ?>">
                                                                                    <a href="./youtube_play.php?play=<?php echo htmlspecialchars($Data_SubTitle['NO']); ?>">
                                                                                        <div class="card h-100 py-2 align-items-center">
                                                                                            <div class="card-body">
                                                                                                <div class="col-auto" style="text-align: center;">
                                                                                                    <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($Data_SubTitle['videoId']); ?>/0.jpg" style="width: 100%;">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                        <?php
                                                                            } // end of while loop for videos
                                                                        } else {
                                                                            // 해당 채널의 비디오가 없을 경우
                                                                        ?>
                                                                            <div class="col-12 collapse" id="<?php echo htmlspecialchars($collapseId); ?>">
                                                                                <p class="text-center mt-3">아직 등록된 영상이 없습니다.</p>
                                                                            </div>
                                                                        <?php
                                                                        } // end of if for videos
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } catch (Throwable $e) {
                                                        // 데이터베이스 쿼리 중 오류 발생 시
                                                        error_log("YouTube Channel Data Query Failed for '" . $channelTitle . "': " . $e->getMessage());
                                                        // 사용자에게는 오류 메시지를 표시하지 않고 다음 채널로 진행하거나, 적절한 오류 메시지를 보여줄 수 있습니다.
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="alert alert-danger" role="alert">
                                                                    <strong>오류 발생:</strong> 채널 '<?php echo htmlspecialchars($channelTitle); ?>'의 정보를 불러오지 못했습니다.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } finally {
                                                        // 사용한 statement와 result를 정리합니다.
                                                        if (isset($stmt_channel) && $stmt_channel) {
                                                            $stmt_channel->close();
                                                        }
                                                        if (isset($Result_Channelinfo) && $Result_Channelinfo) {
                                                            $Result_Channelinfo->free();
                                                        }
                                                        if (isset($stmt_videos) && $stmt_videos) {
                                                            $stmt_videos->close();
                                                        }
                                                        if (isset($Result_PLAYCOUNT) && $Result_PLAYCOUNT) {
                                                            $Result_PLAYCOUNT->free();
                                                        }
                                                    }
                                                } // end of foreach channelTitles
                                            ?>