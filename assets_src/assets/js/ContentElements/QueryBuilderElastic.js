(function ($, window, document) {
  'use strict';

  window.QueryBuilderConstants = window.QueryBuilderConstants || {};
  QueryBuilderConstants.COMPARATOR_MATCH = 'match';
  QueryBuilderConstants.COMPARATOR_NOT_MATCH = 'nmatch';
  QueryBuilderConstants.COMPARATOR_MATCH_PHRASE = 'matchphrase';
  QueryBuilderConstants.COMPARATOR_NOT_MATCH_PHRASE = 'nmatchphrase';
  QueryBuilderConstants.COMPARATOR_MATCH_PHRASE_PREFIX = 'matchphrasepre';
  QueryBuilderConstants.COMPARATOR_NOT_MATCH_PHRASE_PREFIX = 'nmatchphrasepre';
  QueryBuilderConstants.COMPARATOR_WILDCARD = 'wild';
  QueryBuilderConstants.COMPARATOR_NOT_WILDCARD = 'nwild';
  QueryBuilderConstants.COMPARATOR_FUZZY = 'fuzzy';
  QueryBuilderConstants.COMPARATOR_NOT_FUZZY = 'nfuzzy';

  $(document).on(
    'init.querybuilder', function (e, qb, i) {
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_MATCH, 'Match Any');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_MATCH, 'Does Not Match Any');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_MATCH_PHRASE, 'Matches Phrase');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_MATCH_PHRASE, 'Does Not Match Phrase');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_MATCH_PHRASE_PREFIX, 'Matches Phrase Prefix');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_MATCH_PHRASE_PREFIX, 'Does Not Match Phrase Prefix');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_WILDCARD, 'Wildcard Match');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_WILDCARD, 'Does Not Match Wildcard');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_FUZZY, 'Fuzzy Match With');
      i.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_FUZZY, 'Does Not Fuzzy Match With');
    }
  );

}(jQuery, window, document));
