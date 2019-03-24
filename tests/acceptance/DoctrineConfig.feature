Feature: Doctrine configuration integration
  In order to use enhanced doctrine checks
  As a Psalm user
  I need this plugin to be able to grok doctrine configuration

  Scenario: Running without doctrine config
    Given I have the following config
      """
      <?xml version="1.0"?>
      <psalm totallyTyped="true">
        <projectFiles>
          <directory name="."/>
        </projectFiles>
        <plugins>
          <pluginClass class="Weirdan\DoctrinePsalmPlugin\Plugin" />
        </plugins>
      </psalm>
      """
    And I have the following code preamble
      """
      <?php
      """
    # Psalm module apparently misses code reset (or file removal)
    And I have the following code
      """
      """
    When I run Psalm
    Then I see these errors
      | Type          | Message                                                         |
      | MissingConfig | To use extended checks please add Doctrine plugin configuration |
    And I see no other errors
